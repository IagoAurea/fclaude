<?php

namespace Modules\Scouting\Database\Seeders;

use Illuminate\Database\Seeder;

class ScoutingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            ActionsTableSeeder::class
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
