<?php

namespace Modules\User\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;
use Modules\User\Repositories\Interfaces\ModelPermissionRepositoryInterface;

class PermissionService
{
    use ResponseTrait;

    /**
     * @var object $permissionRepository
     */
    protected $permissionRepository;

    /**
     * @var object $modelPermissionRepository
     */
    protected $modelPermissionRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * @var object $userRepository
     */
    protected $userRepository;

    /**
     * @var object $teamStaffRelationsRepository
     */
    protected $teamStaffRelationsRepository;

    /**
     * Instance a new service class.
     */
    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
        ModelPermissionRepositoryInterface $modelPermissionRepository,
        ClubRepositoryInterface $clubRepository,
        TeamRepositoryInterface $teamRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->permissionRepository = $permissionRepository;
        $this->modelPermissionRepository = $modelPermissionRepository;
        $this->clubRepository = $clubRepository;
        $this->teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Returns the list of all permissions in usae to be setted
     * @return Array
     * 
     * @OA\Schema(
     *  schema="PermissionListResponse",
     *  type="object",
     *  description="Returns the list of all permissions",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Permission Items List"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="index", type="int64", example="1"),
     *          @OA\Property(property="type", type="string"),
     *          @OA\Property(
     *              property="permissions",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *                  @OA\Property(property="entity_code", type="int64", example="string"),
     *              )
     *          )
     *      ),
     *  ),
     * )
     */
    public function listPermissions()
    {
        try {
            $permissions = $this->permissionRepository->listPermissions();

            $grouped = $permissions->groupBy('entity_code');

            $parsed = [];
            $count = 1;
    
            foreach ($grouped as $key => $value) {
                $parsed[] = [
                    'index' => $count,
                    'type' => $key,
                    'permissions' => $value
                ];
    
                $count ++;
            }
    
            return $parsed;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a list of all users permissions
     * @param Integer $userId
     * @param Integer|String $entityId
     * @param Integer|String $entityType
     * 
     * @OA\Schema(
     *  schema="UserPermissionListResponse",
     *  type="object",
     *  description="Returns a list of user entity related permissions",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="User Permissions List"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="entity",
     *              type="object",
     *              @OA\Property(property="id", type="number", format="int64", example="1"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="type", type="string"),
     *          ),
     *          @OA\Property(
     *              property="permissions",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *                  @OA\Property(property="entity_code", type="int64", example="string"),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function listUserPermissions($userId, $entityId = NULL, $entityType = NULL)
    {
        $permissions = $this->modelPermissionRepository->listUserPermissions($userId, $entityId, $entityType);
        $groupedTypeEntityPermissions = $permissions->groupBy('entity_type');
        $data = [];

        // Group all permission set by entity types and start looping
        foreach ($groupedTypeEntityPermissions as $classType => $entityGroup) {
            $entities = $entityGroup->groupBy('entity_id');

            // Loop through every entity related to the previous group
            foreach ($entities as $classId => $entityPermissions) {
                $permissionData = [];

                // Loop through every permission related to the previous entity
                // and start parsing the data for its return
                foreach ($entityPermissions as $modelPermission) {
                    $permissionData[] = $modelPermission->permission;
                }

                $entityData = $this->getEntityData($classType, $classId);

                $data[] = [
                    'entity' => $entityData,
                    'permissions' => $permissionData,
                ];
            }
        }

        return $data;
    }

    /**
     * Retrieves a list of all users with permissions
     * 
     * type='club' retrieves all users from all teams depending from a club
     * type='team' retrieves all users depending only from the selected team
     * 
     * @param String $entityId
     * @param String $entityType
     * @return array
     * 
     * @OA\Schema(
     *  schema="EntityUserPermissionsListResponse",
     *  type="object",
     *  description="Returns a list of user entity related permissions",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="User Permissions List"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="number", format="int64", example="1"),
     *          @OA\Property(property="full_name", type="string"),
     *          @OA\Property(property="email", format="email", type="string"),
     *          @OA\Property(property="active", type="boolean"),
     *          @OA\Property(property="username", type="string"),
     *          @OA\Property(property="area", type="string"),
     *          @OA\Property(property="position", type="string"),
     *          @OA\Property(
     *              property="teams",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="number", format="int64", example="1"),
     *                  @OA\Property(property="code", type="string"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="image_url", type="string"),
     *                  @OA\Property(
     *                      property="permissions",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="number", format="int64", example="1"),
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="entity_code", type="string"),
     *                      )
     *                  ),
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    // public function listPermissionsByEntity($entityType, $entityId)
    // {
    //     $classType = $entityType == 'team' ? 'Modules\Team\Entities\Team' : 'Modules\Club\Entities\Club';
    //     $entity = $this->getEntity($classType, $entityId);

    //     // Array asseting for data parsing
    //     $teamIds = [];
    //     $baseData = [];

    //     if ($entityType == 'club') {
    //         // Pluck simple team ids
    //         $teamIds = $entity->teams->pluck('id');

    //         // Get the all team staffs excluded from the club's teams
    //         $teamStaffs = $this->teamStaffRelationsRepository->findExcludedStaffs(
    //             $teamIds
    //         );

    //         foreach ($teamStaffs as $teamStaff) {
    //             // Initialize team base data array
    //             $teamBaseData = [];

    //             foreach ($teamStaff->teams as $team) {
    //                 // Get the permission set from model relation permissions
    //                 $relatedPermissions = $this->modelPermissionRepository->listUserPermissions(
    //                     $teamStaff->user_id, $team->id, 'team'
    //                 )->map(function ($relation) {
    //                     return $relation->permission;
    //                 });

    //                 // Set an inner item to the teams array resolved with permissions
    //                 $teamBaseData[] = $this->resolveTeamData($team, $relatedPermissions);
    //             }
                
    //             // Set an extra item to the base data relation in the final returning array
    //             $baseData[] = $this->resolveUserData($teamStaff->user, $teamBaseData, $teamStaff);
    //         }

    //         return $baseData;
    //     }
    // }

    /**
     * Retrieves full entity data
     * 
     * @return 
     */
    public function getEntityData($classType, $classId)
    {
        $condition = [
            'id' => $classId
        ];

        if ($classType == 'Modules\Team\Entities\Team') {
            $team = $this->teamRepository->findOneBy($condition);

            if ($team) {
                return [
                    'id' => $team->id,
                    'code' => $team->code,
                    'name' => $team->name,
                    'type' => 'team',
                ];
            }

        }

        $club = $this->clubRepository->findOneBy($condition);

        if ($club) {
            return [
                'id' => $club->id,
                'name' => $club->name,
                'type' => 'club',
            ];

        }
    }

    /**
     * Return the full eloquent entity
     * 
     * @return mixed
     */
    private function getEntity($classType, $classId)
    {
        $condition = [
            'id' => $classId
        ];

        if ($classType == 'Modules\Team\Entities\Team') {
            return $this->teamRepository->findOneBy($condition);
        }

        return $this->clubRepository->findOneBy($condition);
    }

    /**
     * Destructure specific team data
     * 
     * @return array
     */
    private function resolveTeamData($team, $permissions = [])
    {
        return [
            'id' => $team->id,
            'code' => $team->code,
            'name' => $team->name,
            'image_url' => $team->image_url,
            'permissions' => $permissions,
        ];
    }

    /**
     * Destructure specific user data
     * 
     * @return array
     */
    private function resolveUserData($user, $teamsData, $staff = NULL)
    {
        // Set basic user information into array
        $userData = [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'active' => $user->active,
            'username' => $user->username,
        ];

        // If no staff is sent just return the common array
        if (!$staff) {
            $userData['teams'] = $teamsData;
            return $userData;
        }

        // Add extra staff information to returning array
        $userData['area'] = $staff->area->name;
        $userData['position'] = $staff->position_staff->name;
        $userData['teams'] = $teamsData;

        return $userData;
    }
}
