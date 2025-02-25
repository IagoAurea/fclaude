<?php

namespace Modules\Team\Database\Seeders;

use Illuminate\Database\Seeder;

class TeamDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            ActivityTypeTableSeeder::class,
            TeamsTypeTableSeeder::class,
            TeamsModalityTableSeeder::class,
            TeamsTableSeeder::class,
            TypeLineupsTableSeeder::class
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
