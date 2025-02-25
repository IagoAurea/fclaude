<?php

namespace Modules\Classroom\Database\Seeders;

use Illuminate\Database\Seeder;

class ClassroomDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            AgeTableSeeder::class,
            SubjectTableSeeder::class,
            TeacherTableSeeder::class,
            ClassroomTableSeeder::class,
            // ClassroomExerciseTableSeeder::class,
            // ClassroomExerciseSessionTableSeeder::class,
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
