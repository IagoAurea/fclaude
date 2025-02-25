<?php

namespace Modules\Calculator\Database\Seeders;

use Illuminate\Database\Seeder;

// Seeder Modules
use Modules\Calculator\Database\Seeders\InjuryPrevention\CalculatorItemsTableSeeder as InjuryPreventionItemSeeder;
use Modules\Calculator\Database\Seeders\InjuryPrevention\OptionPointTableSeeder as InjuryPreventionOptionSeeder;

class CalculatorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            CalculatorItemTypeTableSeeder::class,
            InjuryPreventionItemSeeder::class,
            InjuryPreventionOptionSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
