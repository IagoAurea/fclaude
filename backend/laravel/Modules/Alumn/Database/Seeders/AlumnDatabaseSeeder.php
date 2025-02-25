<?php

namespace Modules\Alumn\Database\Seeders;

use Illuminate\Database\Seeder;

class AlumnDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            AcneaeTableSeeder::class,
            AlumnTableSeeder::class,
            ClassroomAcademicYearAlumnTableSeeder::class,
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
