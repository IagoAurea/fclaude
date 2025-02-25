<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;

class SubpackagesTableSeeder extends Seeder
{
    /** 
     * @var object
     */
    protected $subpackageRepository;
    
    /** 
     * @var object
     */
    protected $packageRepository;

    public function __construct(
        PackageRepositoryInterface $packageRepository, 
        SubpackageRepositoryInterface $subpackageRepository
    )
    {
        $this->packageRepository = $packageRepository;
        $this->subpackageRepository = $subpackageRepository;
    }
    
    /**
     * @return void
     */
    protected function createSubpackages(array $elements)
    {
        foreach($elements as $elm) 
        {
            $this->subpackageRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        $sportPackage = $this->packageRepository->findOneBy(['code' => 'sport']);
        $teacherPackage = $this->packageRepository->findOneBy(['code' => 'teacher']);
       
        yield [
            [
                'es' => [
                    'name' => 'Deporte Bronce'
                ],
                'en' => [
                    'name' => 'Sport Bronze'
                ],
                'code' => 'sport_bronze',
                'package_id' => $sportPackage->id
            ],
            [
                'es' => [
                    'name' => 'Deporte Plata'
                ],
                'en' => [
                    'name' => 'Sport Silver'
                ],
                'code' => 'sport_silver',
                'package_id' => $sportPackage->id
            ],
            [
                'es' => [
                    'name' => 'Deporte Oro'
                ],
                'en' => [
                    'name' => 'Sport Gold'
                ],
                'code' => 'sport_gold',
                'package_id' => $sportPackage->id
            ],
            [
                'es' => [
                    'name' => 'P.E. Profesor Bronce'
                ],
                'en' => [
                    'name' => 'P.E. Teacher Bronze'
                ],
                'code' => 'teacher_bronze',
                'package_id' => $teacherPackage->id
            ],
            [
                'es' => [
                    'name' => 'P.E. Profesor Plata'
                ],
                'en' => [
                    'name' => 'P.E. Teacher Silver'
                ],
                'code' => 'teacher_silver',
                'package_id' => $teacherPackage->id
            ],
            [
                'es' => [
                    'name' => 'P.E. Profesor Oro'
                ],
                'en' => [
                    'name' => 'P.E. Teacher Gold'
                ],
                'code' => 'teacher_gold',
                'package_id' => $teacherPackage->id
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSubpackages($this->get()->current());
    }
}
