<?php

namespace Modules\Nutrition\Database\Seeders;

use Illuminate\Database\Seeder;

class NutritionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            SupplementsTableSeeder::class,
            DietsTableSeeder::class,
            ActivityTypeTableSeeder::class,
            NutritionalSheetTableSeeder::class,
            WeightControlTableSeeder::class
            
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
