<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Test\Repositories\Interfaces\QuestionCategoryRepositoryInterface;


class QuestionCategoryTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $questionCategoryRepository;

    public function __construct(QuestionCategoryRepositoryInterface $questionCategoryRepository)
    {
        $this->questionCategoryRepository = $questionCategoryRepository;
    }

    /**
     * @return void
     */
    protected function createQuestionCategory(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->questionCategoryRepository->create($elm);
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
                    'name' => 'Habilidades motrices especializadas'
                ],
                'en' => [
                    'name' => 'Specialized motor skills'
                ],
                'code'           => 'special_skills'
            ],
            [
                'es' => [
                    'name' => 'Capacidades físicas'
                ],
                'en' => [
                    'name' => 'Physical abilities'
                ],
                'code'           => 'physical_abilities'
            ],
            [
                'es' => [
                    'name' => 'Fuerza'
                ],
                'en' => [
                    'name' => 'Force'
                ],
                'code'           => 'force',
                'question_category_code' => 'physical_abilities',
            ],
            [
                'es' => [
                    'name' => 'Flexibilidad'
                ],
                'en' => [
                    'name' => 'Flexibility'
                ],
                'code'           => 'flexibility',
                'question_category_code' => 'physical_abilities',
            ],
            [
                'es' => [
                    'name' => 'Velocidad'
                ],
                'en' => [
                    'name' => 'Speed'
                ],
                'code'           => 'speed',
                'question_category_code' => 'physical_abilities',
            ],
            [
                'es' => [
                    'name' => 'Resistencia'
                ],
                'en' => [
                    'name' => 'Endurance'
                ],
                'code'           => 'endurance',
                'question_category_code' => 'physical_abilities',
            ],
            [
                'es' => [
                    'name' => 'Agilidad'
                ],
                'en' => [
                    'name' => 'Agility'
                ],
                'code'           => 'agility',
                'question_category_code' => 'physical_abilities',
            ],
            [
                'es' => [
                    'name' => 'Habilidades motrices específicas'
                ],
                'en' => [
                    'name' => 'Specific motor skills'
                ],
                'code'           => 'specific_skills',
            ],
            [
                'es' => [
                    'name' => 'Manifestaciones físicas para el rendimiento'
                ],
                'en' => [
                    'name' => 'Physical manifestations for performance'
                ],
                'code'           => 'physical_manifestations',
            ],
            [
                'es' => [
                    'name' => 'Test 1'
                ],
                'en' => [
                    'name' => 'Test 1'
                ],
                'code'           => 'test_1'
            ],
            [
                'es' => [
                    'name' => 'Test 2'
                ],
                'en' => [
                    'name' => 'Test 2'
                ],
                'code'           => 'test_2'
            ],
            [
                'es' => [
                    'name' => 'Test 3'
                ],
                'en' => [
                    'name' => 'Test 3'
                ],
                'code'           => 'test_3'
            ],
            [
                'es' => [
                    'name' => 'Pierna derecha'
                ],
                'en' => [
                    'name' => 'Right leg'
                ],
                'code'           => 'right_leg'
            ],
            [
                'es' => [
                    'name' => 'Pierna Izquierda'
                ],
                'en' => [
                    'name' => 'Left leg'
                ],
                'code'           => 'left_leg'
            ],
            [
                'es' => [
                    'name' => 'Lado derecho'
                ],
                'en' => [
                    'name' => 'Right side'
                ],
                'code'           => 'right_side'
            ],
            [
                'es' => [
                    'name' => 'Lado Izquierdo'
                ],
                'en' => [
                    'name' => 'Left side'
                ],
                'code'           => 'left_side'
            ],

            [
                'es' => [
                    'name' => 'FC - Frecuencia cardiaca'
                ],
                'en' => [
                    'name' => 'FC - Heart rate'
                ],
                'code'           => 'heart_rate'
            ],
            [
                'es' => [
                    'name' => 'GPS '
                ],
                'en' => [
                    'name' => 'GPS'
                ],
                'code'           => 'gps'
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
        $this->createQuestionCategory($this->get()->current());
    }
}
