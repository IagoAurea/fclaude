<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PackageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            PackagesTableSeeder::class, 
            AttributesPackTableSeeder::class, 
            SubpackagesTableSeeder::class, 
            AttributesSubpackageTableSeeder::class, 
            AttributesPackageTableSeeder::class, 
            PackagesPriceTableSeeder::class,
            SubpackageSportsTableSeeder::class
        ];
        
        foreach($seeders as $class) {
            $this->call($class);
        }
    }
}
