<?php

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;

class ActivityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ActivityTypeTableSeeder::class);
    }
}
