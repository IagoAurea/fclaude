<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            CountriesTableSeeder::class,
            ProvincesTableSeeder::class,
            JobsAreaTableSeeder::class,
            KinshipsTableSeeder::class,
            StudyLevelsTableSeeder::class,
            SeasonsTableSeeder::class,
            StudyLevelsTableSeeder::class,
            WeathersTableSeeder::class,
            WeekDayTableSeeder::class,
            TaxTableSeeder::class,
            // RefereesTableSeeder::class,
            SplashTableSeeder::class,
            BusinessTableSeeder::class,
            TypeNotificationsTableSeeder::class
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
