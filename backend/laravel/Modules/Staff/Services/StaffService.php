<?php

namespace Modules\Staff\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

// Repositories
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Staff\Repositories\Interfaces\StaffUserRepositoryInterface;

// Services
use Modules\Generality\Services\ResourceService;
use Modules\Address\Services\AddressService;
use Modules\Staff\Services\StaffWorkExperienceService;

class StaffService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $staffUserRepository
     */
    protected $staffUserRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $addressService
     */
    protected $addressService;

    /**
     * @var $staffWorkExperience
     */
    protected $staffWorkExperienceService;

    /**
     * Instance a new service class.
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ResourceRepositoryInterface $resourceRepository,
        StaffUserRepositoryInterface $staffUserRepository,
        ResourceService $resourceService,
        AddressService $addressService,
        StaffWorkExperienceService $staffWorkExperienceService
    ) {
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
        $this->staffUserRepository = $staffUserRepository;
        $this->resourceService = $resourceService;
        $this->addressService = $addressService;
        $this->staffWorkExperienceService = $staffWorkExperienceService;
    }

    /**
     * Returns a list of staff members
     * @return StaffUser[]
     * 
     * @OA\Schema(
     *  schema="ListStaffResponse",
     *  type="object",
     *  description="Returns the list of entity staffs",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Staff member list"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="full_name", type="string", example="string"),
     *          @OA\Property(property="username", type="string", example="string"),
     *          @OA\Property(property="birth_date", type="string", format="date", example="2022-01-01"),
     *          @OA\Property(property="email", type="string", example="string"),
     *          @OA\Property(property="entity_type", type="string", example="string"),
     *          @OA\Property(property="entity_id", type="int64", example="1"),
     *          @OA\Property(property="gender_id", type="int64", example="1"),
     *          @OA\Property(property="study_level_id", type="int64", example="1"),
     *          @OA\Property(property="jobs_area_id", type="int64", example="1"),
     *          @OA\Property(property="position_staff_id", type="int64", example="1"),
     *          @OA\Property(property="responsibility", type="string", example="string"),
     *          @OA\Property(property="additional_information", type="string", example="string"),
     *          @OA\Property(property="image_id", type="int64", example="1"),
     *          @OA\Property(property="is_active", type="boolean", example="true"),
     *          @OA\Property(
     *              property="user",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="full_name", type="string", example="string"),
     *              @OA\Property(property="email", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="gender",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="image",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="url", type="string", example="string"),
     *              @OA\Property(property="mime_type", type="string", example="string"),
     *              @OA\Property(property="size", type="int64", example="91962"),
     *          ),
     *          @OA\Property(
     *              property="study_level",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="job_area",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="position_staff",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="address",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="street", type="string", example="string"),
     *              @OA\Property(property="city", type="string", example="string"),
     *              @OA\Property(property="postal_code", type="string", example="string"),
     *              @OA\Property(property="phone", type="array", @OA\Items(type="string")),
     *              @OA\Property(property="mobile_phone", type="array", @OA\Items(type="string")),
     *              @OA\Property(
     *                  property="country",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *              @OA\Property(
     *                  property="province",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function index($entity, $isActive = null, $listAll = null)
    {
        try {
            $staffs = [];

            $listAllFlag = $listAll == 'true';

            // Only club entities might work with the "listAll" option
            $staffs = $entity->staffs;

            if (get_class($entity) == 'Modules\Club\Entities\Club' && $listAllFlag) {
                foreach ($entity->teams as $team) {
                    foreach ($team->staffs as $staff) {
                        $staffs[] = $staff;
                    }
                }
            }

            if ($isActive) {
                $activeFlag = $isActive == 'true';

                return $staffs->where('is_active', '=', $activeFlag);
            }

            return $staffs;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Stores a new staff member into the database
     * @return StaffUser
     * 
     * @OA\Schema(
     *  schema="StoreStaffResponse",
     *  type="object",
     *  description="Stores a new staff into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Staff member created"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="user_id", type="int64", example="1"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(property="study_level_id", type="int64", example="1"),
     *      @OA\Property(property="jobs_area_id", type="int64", example="1"),
     *      @OA\Property(property="position_staff_id", type="int64", example="1"),
     *      @OA\Property(property="responsibility", type="string", example="string"),
     *      @OA\Property(property="additional_information", type="string", example="string"),
     *      @OA\Property(property="image_id", type="int64", example="1"),
     *      @OA\Property(
     *          property="user",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="full_name", type="string", example="string"),
     *          @OA\Property(property="email", type="string", example="string"),
     *          @OA\Property(property="username", type="string", example="string"),
     *          @OA\Property(property="image", type="string", example="string"),
     *      ),
     *  ),
     * )
     */
    public function store($entity, $userData, $addressData, $staffData)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->findOrCreate([
                'email' => $userData['email']
            ]);

            $existent = $this->staffUserRepository->findOneBy([
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id,
                'user_id' => $user->id,
            ]);

            if ($existent) {
                throw new Exception('User is already staffing this entity', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $imageId = null;

            if (isset($userData['image'])) {
                $imageId = $this->handleStaffImage(NULL, $userData['image']);
            }

            $staffData['entity_id'] = $entity->id;
            $staffData['entity_type'] = get_class($entity);
            $staffData['image_id'] = $imageId;
            $staffData['user_id'] = $user->id;
            $staffData['full_name'] = $userData['full_name'];
            $staffData['email'] = $userData['email'];

            $finalStaffData = array_merge($userData, $staffData);

            $staff = $this->staffUserRepository->create($finalStaffData);

            $this->addressService->store($addressData, $staff);

            if (isset($staffData['work_experience'])) {
                $this->staffWorkExperienceService->bulkStore($staff, $staffData['work_experience']);
            }

            DB::commit();
            return $staff;
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    /**
     * Returns a single staff member
     * @return StaffUser
     *
     * @OA\Schema(
     *  schema="ShowStaffResponse",
     *  type="object",
     *  description="Returns an specific staff member",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Staff data"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="user_id", type="int64", example="1"),
     *      @OA\Property(property="full_name", type="string", example="string"),
     *      @OA\Property(property="username", type="string", example="string"),
     *      @OA\Property(property="birth_date", type="string", format="date", example="2022-01-01"),
     *      @OA\Property(property="email", type="string", example="string"),
     *      @OA\Property(property="entity_type", type="string", example="string"),
     *      @OA\Property(property="entity_id", type="int64", example="1"),
     *      @OA\Property(property="gender_id", type="int64", example="1"),
     *      @OA\Property(property="study_level_id", type="int64", example="1"),
     *      @OA\Property(property="jobs_area_id", type="int64", example="1"),
     *      @OA\Property(property="position_staff_id", type="int64", example="1"),
     *      @OA\Property(property="responsibility", type="string", example="string"),
     *      @OA\Property(property="additional_information", type="string", example="string"),
     *      @OA\Property(property="image_id", type="int64", example="1"),
     *      @OA\Property(
     *          property="entity",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="user",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="email", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="address",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="street", type="string", example="string"),
     *          @OA\Property(property="city", type="string", example="string"),
     *          @OA\Property(property="postal_code", type="string", example="string"),
     *          @OA\Property(property="phone", type="array", @OA\Items(type="string")),
     *          @OA\Property(property="mobile_phone", type="array", @OA\Items(type="string")),
     *      ),
     *      @OA\Property(
     *          property="image",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="url", type="string", example="string"),
     *          @OA\Property(property="mime_type", type="string", example="string"),
     *          @OA\Property(property="size", type="int64", example="91962"),
     *      ),
     *      @OA\Property(
     *          property="study_level",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="job_area",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="position_staff",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="gender",
     *          type="object",
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *      ),
     *      @OA\Property(
     *          property="work_experience",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="name", type="string", example="string"),
     *              @OA\Property(property="occupation", type="string", example="string"),
     *              @OA\Property(property="start_date", type="string", format="date", example="string"),
     *              @OA\Property(property="end_date", type="string", format="date", example="string"),
     *              @OA\Property(property="staff_user_id", type="int64", example="1"),
     *          )
     *      ),
     *  ),
     * )
     */
    public function show($staff)
    {
        $staff->user;
        $staff->image;
        $staff->entity;
        $staff->studyLevel;
        $staff->jobArea;
        $staff->positionStaff;
        $staff->address;
        $staff->workExperiences;
        $staff->active_subscription = $staff->user->activeSubscriptionByType();
        $staff->active_licenses = $staff->user->activeLicenses;

        return $staff;
    }

    /**
     * Updated an existent staff from the database
     * @return boolean
     *
     * @OA\Schema(
     *  schema="UpdateStaffResponse",
     *  type="object",
     *  description="Updates a new staff into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Staff member updated"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true" ),
     * )
     */
    public function update($staff, $entity, $userData, $addressData, $staffData)
    {
        try {
            DB::beginTransaction();

            if (isset($userData['image'])) {
                $imageId = $this->handleStaffImage($staff, $userData['image']);
                $staffData['image_id'] = $imageId;
            }

            if (!$staff->address) {
                $this->addressService->store($addressData, $staff);
            } else {
                $this->addressService->update($addressData, $staff);
            }

            $finalStaffData = array_merge($userData, $staffData);

            $this->staffUserRepository->update($finalStaffData, $staff);

            if (isset($staffData['work_experience'])) {
                $this->staffWorkExperienceService->bulkUpdate($staff, $staffData['work_experience']);
            }

            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    /**
     * Deletes an existent staff from the database
     * @return boolean
     *
     * @OA\Schema(
     *  schema="DeleteStaffResponse",
     *  type="object",
     *  description="Deletes a new staff into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Staff member deleted"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true" ),
     * )
     */
    public function delete($staff)
    {
        return $this->staffUserRepository->delete($staff->id);
    }

    /**
     *
     */
    private function handleStaffImage($staff, $image)
    {
        // Checks for an existent image identificator
        $deletableImageId = null;
        $imageId = null;

        if (isset($image)) {
            // Do the normal image uploading
            $dataResource = $this->uploadResource('/staffs', $image);
            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $imageId = $resource->id;
            }

            // Sets the image id, null if none
            if ($staff) {
                $deletableImageId = $staff->image_id;
            }
        }

        // If there's an image id to be deleted, it gets deleted from resources
        if ($deletableImageId) {
            $this->resourceService->deleteResourceData($deletableImageId);
        }

        return $imageId;
    }
}
