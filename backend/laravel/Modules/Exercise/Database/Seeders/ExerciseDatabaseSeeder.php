<?php

namespace Modules\Exercise\Database\Seeders;

use Illuminate\Database\Seeder;

class ExerciseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            DistributionExercisesTableSeeder::class,
            ContentsExerciseTableSeeder::class,
            ExerciseContentBlockTableSeeder::class,
            ExerciseEducationLevelTableSeeder::class,
            // ExercisesTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
