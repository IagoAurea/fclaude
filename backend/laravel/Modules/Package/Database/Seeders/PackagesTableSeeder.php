<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;

class PackagesTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $packageRepository;

    public function __construct(PackageRepositoryInterface $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    /**
     * @return void
     */
    protected function createPackages(array $elements)
    {
        foreach($elements as $elm) 
        {
            $this->packageRepository->create($elm);
        }
    }

     /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Deporte'
                ],
                'en' => [
                    'name' => 'Sport'
                ],
                'code' => 'sport'
            ],
            [
                'es' => [
                    'name' => 'P.E. Profesor'
                ],
                'en' => [
                    'name' => 'P.E. Teacher'
                ],
                'code' => 'teacher'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPackages($this->get()->current());
    }
}
