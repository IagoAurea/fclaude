<?php

namespace Modules\User\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\User\Repositories\Interfaces\RoleRepositoryInterface;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionsTableSeeder extends BaseSeeder
{
    /**
     * @var array
     * return list role
     */
    const PERMISSIONS = [
        'list',
        'create',
        'edit',
        'read',
        'delete'
    ];
    
    /**
     * @var object
     */
    protected $roleRepository;

    /**
     * @var object
     */
    protected $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }
    
    /**
     * @return void
     */
    protected function createPermissions()
    {

        foreach(self::PERMISSIONS as $permission) {
            $this->permissionRepository->create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
    }

    /**
     * @return void
     */
    protected function assignPermissionsToRole()
    {
        $roles = $this->roleRepository->findAll();

        foreach($roles as $role) {
            if($role->name == 'admin') {
                $role->syncPermissions(self::PERMISSIONS);

                continue;
            }

            $permissionsRand = array_rand(self::PERMISSIONS, 4);

            $role->syncPermissions($permissionsRand);
        }
    }

    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();
        $this->assignPermissionsToRole();
    }
}
