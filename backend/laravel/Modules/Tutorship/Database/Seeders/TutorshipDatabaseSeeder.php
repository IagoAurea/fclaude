<?php

namespace Modules\Tutorship\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TutorshipDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TutorshipTypesSeeder::class);
        $this->call(SpecialistReferralSeeder::class);
    }
}
