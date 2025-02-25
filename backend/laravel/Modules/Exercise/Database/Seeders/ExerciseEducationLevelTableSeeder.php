<?php

namespace Modules\Exercise\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Exercise\Repositories\Interfaces\ExerciseEducationLevelRepositoryInterface;

class ExerciseEducationLevelTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $educationLevelRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(ExerciseEducationLevelRepositoryInterface $educationLevelRepository)
    {
        $this->educationLevelRepository = $educationLevelRepository;
    }

    /**
     * @return void
     */
    protected function createEducationLevels(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->educationLevelRepository->create($elm);
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
                    'name' => 'Escuela infantil'
                ],
                'en' => [
                    'name' => 'Preschool'
                ],
                'code' => 'preschool'
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
        $this->createEducationLevels($this->get()->current());
    }
}
