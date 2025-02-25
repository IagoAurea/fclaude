<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HealthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            DiseasesTableSeeder::class,
            AllergiesTableSeeder::class,
            PhysicalProblemsTableSeeder::class,
            TypeMedicinesTableSeeder::class,
            AlcoholConsumptionsTableSeeder::class,
            TobaccoConsumptionsTableSeeder::class,
            AreasBodyTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
