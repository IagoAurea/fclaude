<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            RolesTableSeeder::class, 
            PermissionsTableSeeder::class, 
            UsersTableSeeder::class
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
