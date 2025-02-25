<?php

namespace Modules\Evaluation\Database\Seeders;

use Illuminate\Database\Seeder;

class EvaluationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            CompetenceSeeder::class
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
