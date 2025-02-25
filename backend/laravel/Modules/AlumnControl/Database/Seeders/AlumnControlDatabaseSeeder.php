<?php

namespace Modules\AlumnControl\Database\Seeders;

use Illuminate\Database\Seeder;

class AlumnControlDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            DailyControlItemTableSeeder::class,
            DailyControlTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
