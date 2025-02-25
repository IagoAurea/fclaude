<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Classroom\Database\Seeders\TeacherAreaTableSeeder;

class ClubDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(SchoolCenterTypeTableSeeder::class);
        $this->call(ClubTypeTableSeeder::class);
        $this->call(ClubTableSeeder::class);
        $this->call(ClubUserTypeTableSeeder::class);
        // $this->call(PositionStaffTableSeeder::class);
        // $this->call(StaffTableSeeder::class);
        $this->call(TeacherAreaTableSeeder::class);
        $this->call(SchoolCenterTableSeeder::class);
        $this->call(AcademicYearTableSeeder::class);
    }
}
