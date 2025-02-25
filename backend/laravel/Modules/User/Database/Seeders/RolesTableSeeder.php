<?php

namespace Modules\User\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\User\Repositories\Interfaces\RoleRepositoryInterface;

class RolesTableSeeder extends BaseSeeder
{

    /**
     * @var array
     * return list role
     */
    const ROLES = [
        'superadmin',
        'admin',
        'api',
        'user'
    ];

     /**
     * @var object
     */
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return void
     */
    protected function createRole()
    {
        foreach(self::ROLES as $role) {
            $this->roleRepository->create([
                'name' => $role,
                'guard_name' => 'api'
            ]);
        }
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRole();
    }
}
