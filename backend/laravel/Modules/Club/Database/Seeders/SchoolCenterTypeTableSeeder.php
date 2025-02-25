<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Club\Repositories\Interfaces\SchoolCenterTypeRepositoryInterface;

class SchoolCenterTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $schoolCenterTypeRepository;

    public function __construct(SchoolCenterTypeRepositoryInterface $schoolCenterTypeRepository)
    {
        $this->schoolCenterTypeRepository = $schoolCenterTypeRepository;
    }

    /**
     * @return void
     */
    protected function createSchoolCenterType(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->schoolCenterTypeRepository->create($elm);
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
                    'name' => 'Preescolar'
                ],
                'en' => [
                    'name' => 'Preschool'
                ],
                'code' => 'initial_education'
            ],
            [
                'es' => [
                    'name' => 'Colegio'
                ],
                'en' => [
                    'name' => 'Elementary School'
                ],
                'code' => 'elementary'
            ],
            [
                'es' => [
                    'name' => 'Instituto'
                ],
                'en' => [
                    'name' => 'High School'
                ],
                'code' => 'high_school'
            ],
            [
                'es' => [
                    'name' => 'Centro de Formación Profesional'
                ],
                'en' => [
                    'name' => 'Professional Training Centre'
                ],
                'code' => 'training_centre'
            ],
            [
                'es' => [
                    'name' => 'Universidad'
                ],
                'en' => [
                    'name' => 'University'
                ],
                'code' => 'university'
            ],
            [
                'es' => [
                    'name' => 'Centro de Adultos'
                ],
                'en' => [
                    'name' => 'Adult Education Centre'
                ],
                'code' => 'adult_centre'
            ],
            [
                'es' => [
                    'name' => 'Otro'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
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
        $this->createSchoolCenterType($this->get()->current());
    }
}
