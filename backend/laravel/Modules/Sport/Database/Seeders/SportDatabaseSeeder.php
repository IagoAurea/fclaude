<?php

namespace Modules\Sport\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            SportsTableSeeder::class,
            SportsPositionsTableSeeder::class,
            SportPositionSpecTableSeeder::class
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
