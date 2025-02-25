<?php

namespace Modules\Club\Http\Controllers;

use Exception;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Club\Services\StaffService;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Services\ResourceService;
use Modules\Club\Http\Requests\UpdateStaffRequest;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\StaffRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserTypeRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Club\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;

class StaffController extends BaseController
{
    use ResourceTrait;

    /**
     * @var  $userRepository
     */
    protected $userRepository;

    /**
     * @var $staffRepository
     */
    protected $staffRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $clubUserRepository
     */
    protected $clubUserRepository;

    /**
     * @var $clubUserTypeService
     */
    protected $clubUserTypeService;

    /**
     * @var $workingExperiencesRepository
     */
    protected $workingExperiencesRepository;

    /**
     * @var $staffService
     */
    protected $staffService;

    /**
    * @var $helper
    */
    protected $helper;

    public function __construct(
        StaffRepositoryInterface $staffRepository,
        ClubUserRepositoryInterface $clubUserRepository, 
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService,
        ClubUserTypeRepositoryInterface $clubUserTypeService,
        WorkingExperiencesRepositoryInterface $workingExperiencesRepository,
        StaffService $staffService,
        UserRepositoryInterface $userRepository,
        Helper $helper
    ) {
        $this->staffRepository = $staffRepository;
        $this->clubUserRepository = $clubUserRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
        $this->clubUserTypeService = $clubUserTypeService;
        $this->workingExperiencesRepository = $workingExperiencesRepository;
        $this->staffService = $staffService;
        $this->userRepository = $userRepository;
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $staffs = $this->staffRepository->getStaffByClub(
            $request->club_id,
            $request->search,
            $request->order
        );

        return $this->sendResponse($staffs, 'List Staff Members');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $staffData = $request->except('club_id','image');
            
            $user = $this->userRepository->findOrCreate([
                'email' => $request->email
            ]);

            if ($request->image) {
                $dataResource = $this->uploadResource('/staff', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $staffData['image_id'] = $resource->id;
                }
            }

            $staffData['mobile_phone'] = $this->helper->stringToJson($request->mobile_phone);
            $staffData['user_id'] = $user->id;
            $staff = $this->staffRepository->create($staffData);

            if ($request->club_id) {
                $this->staffService->createClubUser(
                    $user->id,
                    $request->club_id,
                    $this->clubUserTypeService->getUserTypeByName('staff')->id
                );
            }
            
            $this->staffService->createUpdateWorkinExperiences($request->working_experiences, $staff->id);
            return $this->sendResponse($staff, 'Staff stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing Staff Member', $exception->getMessage());
        }
    }

    /**
     * Show the specified staff.
     * 
     * @param Int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $staff = $this->staffRepository->getStaffById($id);
            return $this->sendResponse($staff, 'Staff data');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Staff', $exception->getMessage());
        }
    }

    /**
     * Update the satff data sent on storage.
     * 
     * @param Request $request
     * @param Int $id
     * @return Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        try {
            $staff = $this->staffRepository->getStaffById($id);

            $staffData = $request->except('club_id','image','email');
            
            if ($request->image) {
                $dataResource = $this->uploadResource('/staff', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                $staffData['image_id'] = $resource->id;

            }
            
            $this->staffService->createUpdateWorkinExperiences($request->working_experiences, $staff->id);

            $staffData['mobile_phone'] = $this->helper->stringToJson($request->mobile_phone);
            $this->staffRepository->update($staffData, $staff);

            return $this->sendResponse($staff, 'Staff data updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating Staff', $exception->getMessage());
        }
    }

    /**
     * Makes a logical staff deletion from database.
     *
     * @param Int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {

            $this->staffRepository->delete($id);

            return $this->sendResponse(NULL, 'Staff deleted', Response::HTTP_ACCEPTED);
            
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting staff', $exception->getMessage());
        }
    }
}
