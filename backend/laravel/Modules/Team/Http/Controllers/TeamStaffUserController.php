<?php

namespace Modules\Team\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Http\Controllers\Rest\BaseController;

// Entities
use Modules\Team\Entities\Team;
use Modules\Staff\Entities\StaffUser;

// Services
use Modules\Staff\Services\StaffService;

class TeamStaffUserController extends BaseController
{
    use ResourceTrait;

    const USER_VALUES = [
        'full_name',
        'email',
        'birth_date',
        'alias',
        'gender_id',
        'image',
    ];

    const ADDRESS_VALUES = [
        'street',
        'city',
        'postal_code',
        'country_id',
        'province_id',
        'phone',
        'mobile_phone',
    ];

    const STAFF_VALUES = [
        'responsibility',
        'jobs_area_id',
        'study_level_id',
        'additional_information',
        'work_experience',
        'position_staff_id',
    ];

    /**
     * @var object
     */
    protected $staffService;

    /**
     * Creates a new controller instance.
     */
    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * Display a listing of team staff member list.
     * @param $team
     * @param Request $request
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/teams/{team_id}/staffs",
     *  tags={"Team/Staff"},
     *  summary="Team Staff Member Index",
     *  operationId="list-team-staff-member",
     *  description="Returns a list of all staff members related to a team",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/active"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List team staff members",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function index(Request $request, Team $team)
    {
        $staffs = $this->staffService->index($team, $request->active);
        return $this->sendResponse($staffs, 'Staff member list');
    }

    /**
     * Stores a new staff member into the team.
     * 
     * @param Request $request
     * @param Int $id
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/teams/{team_id}/staffs",
     *  tags={"Team/Staff"},
     *  summary="Team Staff Member Store",
     *  operationId="store-team-staff-member",
     *  description="Returns a list of all staff members related to a team",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreStaffUserRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Recently stored staff member",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(Request $request, Team $team)
    {
        try {
            $userData = $request->only(self::USER_VALUES);
            $addressData = $request->only(self::ADDRESS_VALUES);
            $staffData = $request->only(self::STAFF_VALUES);

            $staff = $this->staffService->store(
                $team,
                $userData,
                $addressData,
                $staffData
            );

            return $this->sendResponse($staff, 'Staff member created', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing staff user', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of team staff member list.
     * @param $team
     * @param Request $request
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/teams/{team_id}/staffs/{staff_id}",
     *  tags={"Team/Staff"},
     *  summary="Team Staff Member Show",
     *  operationId="show-team-staff-member",
     *  description="Returns specific staff member related to a team",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/staff_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieve specific staff member",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function show(Team $team, StaffUser $staffUser)
    {
        try {
            $staff = $this->staffService->show($staffUser);
            return $this->sendResponse($staff, 'Staff data');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving staff user', $exception->getMessage());
        }
    }

    /**
     * Stores a new staff member into the team.
     * 
     * @param Request $request
     * @param Int $id
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/teams/{team_id}/staffs/{staff_id}",
     *  tags={"Team/Staff"},
     *  summary="Team Staff Member Update",
     *  operationId="update-team-staff-member",
     *  description="Updates a single staff item",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/staff_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/UpdateStaffUserRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Recently stored staff member",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(Request $request, Team $team, StaffUser $staffUser)
    {
        try {
            $userData = $request->only(self::USER_VALUES);
            $addressData = $request->only(self::ADDRESS_VALUES);
            $staffData = $request->only(self::STAFF_VALUES);

            $staff = $this->staffService->update(
                $staffUser,
                $team,
                $userData,
                $addressData,
                $staffData
            );

            return $this->sendResponse($staff, 'Staff updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating staff user', $exception->getMessage());
        }
    }

    /**
     * Stores a new staff member into the team.
     * 
     * @param Request $request
     * @param Int $id
     * @return Response
     * 
     * @OA\Delete(
     *  path="/api/v1/teams/{team_id}/staffs/{staff_id}",
     *  tags={"Team/Staff"},
     *  summary="Team Staff Member Delete",
     *  operationId="delete-team-staff-member",
     *  description="Deletes a single staff item",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/staff_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Recently stored staff member",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function delete(Team $team, StaffUser $staffUser)
    {
        try {
            $staff = $this->staffService->delete($staffUser);
            return $this->sendResponse($staff, 'Staff deleted');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting staff user', $exception->getMessage());
        }
    }
}
