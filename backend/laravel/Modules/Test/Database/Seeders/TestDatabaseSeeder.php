<?php

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            TestTypeTableSeeder::class,
            TypeValorationTableSeeder::class,
            UnitTableSeeder::class,
            TestSubTypeTableSeeder::class,
            ConfigurationTableSeeder::class,
            QuestionTableSeeder::class,
            ResponseTableSeeder::class,
            UnitGroupTableSeeder::class,
            TestTableSeeder::class,
            FormulaTableSeeder::class
        ];

        foreach ($seeders as $class) {
            $this->call($class);
        }
    }
}
