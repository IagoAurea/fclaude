<?php

namespace Modules\Fisiotherapy\Database\Seeders;

use Illuminate\Database\Seeder;

class FisiotherapyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            TreatmentTableSeeder::class,
            TestTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
