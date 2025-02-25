<?php

namespace Modules\Family\Database\Seeders;

use Illuminate\Database\Seeder;

class FamilyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            FamilyMemberTypeTableSeeder::class,
        ];

        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
