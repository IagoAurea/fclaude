<?php

namespace Modules\Psychology\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PsychologyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            PsychologySpecialistsTableSeeder::class
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
