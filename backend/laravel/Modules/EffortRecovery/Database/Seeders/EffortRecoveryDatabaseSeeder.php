<?php

namespace Modules\EffortRecovery\Database\Seeders;

use Illuminate\Database\Seeder;

class EffortRecoveryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            EffortRecoveryStrategyTableSeeder::class,
            WellnessQuestionnaireAnswerTypeTableSeeder::class,
            WellnessQuestionnaireAnswerItemTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
