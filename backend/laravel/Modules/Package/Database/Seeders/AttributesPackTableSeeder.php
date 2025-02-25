<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;

class AttributesPackTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $attributePackRepository;

    public function __construct(AttributePackRepositoryInterface $attributePackRepository)
    {
        $this->attributePackRepository = $attributePackRepository;
    }

    /**
     * @return void
     */
    protected function createAttributes(array $elements)
    {
        foreach($elements as $elm) 
        {
            $this->attributePackRepository->create($elm);
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
                    'name' => 'Clubs'
                ],
                'en' => [
                    'name' => 'Clubs'
                ],
                'code' => 'clubs'
            ],
            [
                'es' => [
                    'name' => 'Temporadas'
                ],
                'en' => [
                    'name' => 'Seasons'
                ],
                'code' => 'seasons'
            ],
            [
                'es' => [
                    'name' => 'Equipos'
                ],
                'en' => [
                    'name' => 'Teams'
                ],
                'code' => 'teams'
            ],
            [
                'es' => [
                    'name' => 'Competición'
                ],
                'en' => [
                    'name' => 'Competition'
                ],
                'code' => 'competition'
            ],
            [
                'es' => [
                    'name' => 'Partidos'
                ],
                'en' => [
                    'name' => 'Matches'
                ],
                'code' => 'matches'
            ],
            [
                'es' => [
                    'name' => 'Diseño de ejercicios'
                ],
                'en' => [
                    'name' => 'Exercise design'
                ],
                'code' => 'exercise_design'
            ],
            [
                'es' => [
                    'name' => 'Sesiones de entrenamiento'
                ],
                'en' => [
                    'name' => 'Training sessions'
                ],
                'code' => 'training_sessions'
            ],
            [
                'es' => [
                    'name' => 'Jugadores'
                ],
                'en' => [
                    'name' => 'Players'
                ],
                'code' => 'players'
            ],
            [
                'es' => [
                    'name' => 'Test'
                ],
                'en' => [
                    'name' => 'Test'
                ],
                'code' => 'test'
            ],

            [
                'es' => [
                    'name' => 'Fichas de prevención de lesiones'
                ],
                'en' => [
                    'name' => 'Injury prevention sheets'
                ],
                'code' => 'injury_prevention'
            ],
            [
                'es' => [
                    'name' => 'Programas RFD lesiones'
                ],
                'en' => [
                    'name' => 'RFD programs injuries'
                ],
                'code' => 'rfd_injuries'
            ],
            [
                'es' => [
                    'name' => 'Fichas de fisioterapia'
                ],
                'en' => [
                    'name' => 'Physiotherapy sheets'
                ],
                'code' => 'fisiotherapy'
            ],
            [
                'es' => [
                    'name' => 'Recuperación del esfuerzo'
                ],
                'en' => [
                    'name' => 'Recovery from exertion'
                ],
                'code' => 'recovery_exertion'
            ],
            [
                'es' => [
                    'name' => 'Nutrición'
                ],
                'en' => [
                    'name' => 'Nutrition'
                ],
                'code' => 'nutrition'
            ],
            [
                'es' => [
                    'name' => 'Informes de psicología'
                ],
                'en' => [
                    'name' => 'Psychology reports'
                ],
                'code' => 'psychology_reports'
            ],
            [
                'es' => [
                    'name' => 'Scouting de partidos'
                ],
                'en' => [
                    'name' => 'Scouting'
                ],
                'code' => 'scouting'
            ],

            [
                'es' => [
                    'name' => 'Centro educativo'
                ],
                'en' => [
                    'name' => 'School'
                ],
                'code' => 'school'
            ],
            [
                'es' => [
                    'name' => 'Clases'
                ],
                'en' => [
                    'name' => 'Classes'
                ],
                'code' => 'classes'
            ],
            [
                'es' => [
                    'name' => 'Alumnos'
                ],
                'en' => [
                    'name' => 'Students'
                ],
                'code' => 'students'
            ],
            [
                'es' => [
                    'name' => 'Diseño de ejercicios'
                ],
                'en' => [
                    'name' => 'Exercise design'
                ],
                'code' => 'classroom_exercise'
            ],
            [
                'es' => [
                    'name' => 'Sesiones de ejercicios'
                ],
                'en' => [
                    'name' => 'Exercise sessions'
                ],
                'code' => 'classroom_sessions'
            ],
            [
                'es' => [
                    'name' => 'Escenarios disponibles'
                ],
                'en' => [
                    'name' => 'Available scenarios'
                ],
                'code' => 'scenarios'
            ],
            [
                'es' => [
                    'name' => 'Rubricas'
                ],
                'en' => [
                    'name' => 'Rubrics'
                ],
                'code' => 'rubrics'
            ],
            [
                'es' => [
                    'name' => 'Evaluaciones'
                ],
                'en' => [
                    'name' => 'Evaluations'
                ],
                'code' => 'evaluations'
            ],
            [
                'es' => [
                    'name' => 'Tutorias'
                ],
                'en' => [
                    'name' => 'Tutorials'
                ],
                'code' => 'tutorials'
            ],
            [
                'es' => [
                    'name' => 'Calificaciones'
                ],
                'en' => [
                    'name' => 'Ratings'
                ],
                'code' => 'ratings'
            ],

            [
                'es' => [
                    'name' => 'Realidad Virtual'
                ],
                'en' => [
                    'name' => 'Virtual Reality'
                ],
                'code' => 'virtual_reality'
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
        $this->createAttributes($this->get()->current());
    }
}
