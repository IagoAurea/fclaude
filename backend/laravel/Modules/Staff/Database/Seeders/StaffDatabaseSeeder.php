<?php

namespace Modules\Staff\Database\Seeders;

use Illuminate\Database\Seeder;

class StaffDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StaffUserTableSeeder::class);
    }
}
