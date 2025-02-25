<?php

namespace Modules\Activity\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Activity\Services\ActivityService;
use Modules\Activity\Http\Requests\ActivityIndexRequest;
use Modules\Activity\Repositories\Interfaces\ActivityRepositoryInterface;

class ActivityController extends BaseController
{
    use PaginateTrait;

    /**
     * @var object
     */
    protected $activityRepository;

    /**
     * @var object
     */
    protected $activityService;

    /**
     * Instances a new controller class
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityService $activityService
    ) {
        $this->activityRepository = $activityRepository;
        $this->activityService = $activityService;
    }

    /**
     * Retrieves all the club related activities stored in the databases.
     *
     * @param Int $id
     * @return Response Listing of the activities related
     *
     * @OA\Get(
     *  path="/api/v1/activities",
     *  tags={"Activity"},
     *  summary="Get list Activities - Lista de  actividades",
     *  operationId="list-activities",
     *  description="Return data list activities  - Retorna listado de actividades",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/per_page" ),
     *  @OA\Parameter( ref="#/components/parameters/page" ),
     *  @OA\Parameter( ref="#/components/parameters/activity_entity_type" ),
     *  @OA\Parameter( ref="#/components/parameters/activity_entity_id" ),
     *  @OA\Parameter( ref="#/components/parameters/type_profile" ),
     *  @OA\Response(
     *      response=200,
     *      description="List of entity activities. IMPORTANT entity and secondary_entity are polymorphic objects,
     *      those might change depending on the entity requested via URL",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ActivityListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(ActivityIndexRequest $request)
    {
        try {
            $activities = $this->activityService->getEntityActivities($request);

            $paginatedData = $request->page ? $this->paginateWithAllData($activities, $request) : $activities;
            
            return $this->sendResponse($paginatedData, "Retrieving $request->type activities");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving activities', $exception->getMessage());
        }
    }

    /**
     * Retrieves all activities stored in the databases related to user id.
     * @param Request $request
     * @return Response Listing of the activities related by user
     * @OA\Get(
     *  path="/api/v1/activities/user",
     *  tags={"Activity"},
     *  summary="Get list Activities by user - Lista de  actividades por usuario",
     *  operationId="list-activities-user",
     *  description="Return data list activities by user  - Retorna listado de actividades por usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/skip" ),
     *  @OA\Parameter( ref="#/components/parameters/limit" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function listByUser(Request $request)
    {
        try {
            $activities = $this->activityRepository->findAllByUser(Auth::id(), $request->skip, $request->limit);

            return $this->sendResponse($activities, "Retrieving all activities By User");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving activities by user', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/activities/{team_id}/team",
    *       tags={"Activity"},
    *       summary="Get list Activities by team - Lista de  actividades por equipo",
    *       operationId="list-activities-team",
    *       description="Return data list activities by team  - Retorna listado de actividades por equipo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/team_id" ),
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/skip" ),
    *       @OA\Parameter( ref="#/components/parameters/limit" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Retrieves all activities stored in the databases related to Team id.
     *
     * @param Int $team_id
     * @return Response Listing of the activities related by Team
     */
    public function listByTeam(Request $request, $team_id)
    {
        try {
            $activities = $this->activityRepository->findAllByTeam(
                $team_id, $request->skip, $request->limit
            );

            return $this->sendResponse($activities, "Retrieving all activities By Team");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving activities by team', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/activities/user/clubs",
    *       tags={"Activity"},
    *       summary="Get list Activities by club associate - Lista de  actividades por clubs asociados ",
    *       operationId="list-activities-club",
    *       description="Return data list activities by club  - Retorna listado de actividades por clubs asociados",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/skip" ),
    *       @OA\Parameter( ref="#/components/parameters/limit" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Retrieves all the club related activities stored in the databases.
     *
     * @return Response Listing of activities related to the user's clubs
     */
    public function listRelatedByUser(Request $request)
    {
        try {
            $activities = $this->activityService->getActivitiesByUsersClub(Auth::id(), $request->skip, $request->limit);

            return $this->sendResponse($activities, "Retrieving all  activities by User Clubs");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving activities user', $exception->getMessage());
        }
    }

}
