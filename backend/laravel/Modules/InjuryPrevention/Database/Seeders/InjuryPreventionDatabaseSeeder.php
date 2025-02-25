<?php

namespace Modules\InjuryPrevention\Database\Seeders;

use Illuminate\Database\Seeder;

class InjuryPreventionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            PreventiveProgramTypeTableSeeder::class,
            EvaluationQuestionTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
