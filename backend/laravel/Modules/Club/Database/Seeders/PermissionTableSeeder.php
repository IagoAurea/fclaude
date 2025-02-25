<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;

// Repoository Interfaces
use Modules\User\Repositories\Interfaces\RoleRepositoryInterface;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionTableSeeder extends Seeder
{
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
     * Loops through every permission name listed and stores it in database
     * 
     * @return void
     */
    private function createPermissions()
    {
        // Store the permissions
        foreach (config('permission.names') as $permissionSet) {
            foreach ($permissionSet['codes'] as $codeItem) {
                $this->permissionRepository->create([
                    'name' => $codeItem,
                    'guard_name' => 'api',
                    'entity_code' => $permissionSet['entity_code'],
                ]);    
            }
        }

        // Find the expected role for the permissions to be synced
        // $role = $this->roleRepository->findBy([
        //     'name'  =>  'staff'
        // ])->first();

        // // Get the recently created permissions
        // $fresh_permissions = $this->permissionRepository->findIn('name', config('permission.names'));

        // // Sync all permissions
        // $role->syncPermissions($fresh_permissions);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();
    }
}
