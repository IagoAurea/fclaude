<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Injury\Entities\InjurySeverityLocation;

class InjuryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            ClinicalTestTypeTableSeeder::class,
            InjuryTypeTableSeeder::class,
            InjuryTypeSpecTableSeeder::class,
            InjuryLocationTableSeeder::class,
            InjurySituationTableSeeder::class,
            MechanismsInjuryTableSeeder::class,
            InjuryExtrinsicFactorTableSeeder::class,
            InjuryIntrinsicFactorTableSeeder::class,
            InjurySeverityTableSeeder::class,
            CurrentSituationTableSeeder::class,
            QuestionCategoryTableSeeder::class,
            QuestionTableSeeder::class,
            ResponseTableSeeder::class,
            TestTableSeeder::class,
            PhaseTableSeeder::class,
            ReinstatementCriteriaTableSeeder::class,
            InjuriesTableSeeder::class,
            // InjuryRFDTableSeeder::class,
            InjurySeverityLocationTableSeeder::class
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
