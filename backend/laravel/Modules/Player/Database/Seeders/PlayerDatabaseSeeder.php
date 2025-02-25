<?php

namespace Modules\Player\Database\Seeders;

use Illuminate\Database\Seeder;

class PlayerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            LineupPlayerTypeTableSeeder::class,
            PlayerTableSeeder::class,
            ClubArrivalTypeTableSeeder::class,
            PunctuationTableSeeder::class,
            SkillsTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
