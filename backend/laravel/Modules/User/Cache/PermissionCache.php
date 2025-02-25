<?php

namespace Modules\User\Cache;

use App\Cache\BaseCache;
use Modules\User\Services\PermissionService;
use Modules\User\Repositories\Interfaces\ModelPermissionRepositoryInterface;

class PermissionCache extends BaseCache
{
    const TIME_CACHE = 120;
    /**
     * @var object $modelPermissionRepository
     */
    protected $modelPermissionRepository;

    /**
     * @var object $permissionService
     */
    protected $permissionService;

    public function __construct(
        ModelPermissionRepositoryInterface $modelPermissionRepository,
        PermissionService $permissionService
    )
    {
        parent::__construct('permission');

        $this->modelPermissionRepository = $modelPermissionRepository;
        $this->permissionService = $permissionService;
    }

    public function listUserPermissions($userId, $entityId = null, $entityType = null)
    {
        $key = sprintf('%s-%s-%s-%s', $this->key, $userId, $entityId, $entityType);

        return $this->cache::remember($key, self::TIME_CACHE, function () use ($userId, $entityId, $entityType) {
            $permissions = $this->modelPermissionRepository->listUserPermissions($userId, $entityId, $entityType);

            $groupedTypeEntityPermissions = $permissions->groupBy('entity_type');
    
            $data = [];

            // Group all permission set by entity types and start looping
            foreach ($groupedTypeEntityPermissions as $classType => $entityGroup) {
                $entities = $entityGroup->groupBy('entity_id');

                foreach ($entities as $classId => $entityPermissions) {
                    $permissionData = [];

                    foreach ($entityPermissions as $modelPermission) {
                        $permissionData[] = $modelPermission->permission;
                    }

                    $entityData = $this->permissionService->getEntityData($classType, $classId);

                    $data[] = [
                        'entity' => $entityData,
                        'permissions' => $permissionData,
                    ];
                }
            }
            
            return $data;
        });
    }

}