<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Competition\Entities\CompetitionMatch;

class CompetitionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
          TypeCompetitionsTableSeeder::class,
          TypeCompetitionSportsTableSeeder::class,
          TestCategoriesMatchTableSeeder::class,
          TestTypeCategoriesMatchTableSeeder::class,
          CompetitionTableSeeder::class,
        // RivalTeamTableSeeder::class,
        //   MatchTableSeeder::class,
          TypeModalitiesMatchTableSeeder::class
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
