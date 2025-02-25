<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;

class TrainingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            TypeExerciseSessionsTableSeeder::class,
            TrainingPeriodsTableSeeder::class,
            SubContentSesionsTableSeeder::class,
            SubjecPerceptEffortTableSeeder::class,
            TargetSessionsTableSeeder::class,
            ActivityTypeTableSeeder::class,
            TestTableSeeder::class
            // ExerciseSessionTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
