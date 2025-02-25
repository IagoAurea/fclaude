<?php

namespace Modules\Exercise\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRepositoryInterface;

class ExerciseContentBlockTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $contentBlockRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(ExerciseContentBlockRepositoryInterface $contentBlockRepository)
    {
        $this->contentBlockRepository = $contentBlockRepository;
    }

    /**
     * @return void
     */
    protected function createExerciseContentBlocks(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->contentBlockRepository->create($elm);
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
                    'name' => 'Salud'
                ],
                'en' => [
                    'name' => 'Health'
                ],
                'code' => 'health'
            ],
            [
                'es' => [
                    'name' => 'Conciencia corporal'
                ],
                'en' => [
                    'name' => 'Body awareness'
                ],
                'code' => 'body_awareness '
            ],
            [
                'es' => [
                    'name' => 'Calentamiento'
                ],
                'en' => [
                    'name' => 'Warm up'
                ],
                'code' => 'warm_up'
            ],
            [
                'es' => [
                    'name' => 'Vuelta a la calma'
                ],
                'en' => [
                    'name' => 'Cool down'
                ],
                'code' => 'cool_down'
            ],
            [
                'es' => [
                    'name' => 'Condición física'
                ],
                'en' => [
                    'name' => 'Physical condition'
                ],
                'code' => 'physical_condition'
            ],
            [
                'es' => [
                    'name' => 'Fuerza'
                ],
                'en' => [
                    'name' => 'Strength'
                ],
                'code' => 'strength'
            ],
            [
                'es' => [
                    'name' => 'Resistencia'
                ],
                'en' => [
                    'name' => 'Endurance'
                ],
                'code' => 'endurance'
            ],
            [
                'es' => [
                    'name' => 'Flexibilidad'
                ],
                'en' => [
                    'name' => 'Flexibility'
                ],
                'code' => 'flexibility'
            ],
            [
                'es' => [
                    'name' => 'Velocidad'
                ],
                'en' => [
                    'name' => 'Speed'
                ],
                'code' => 'speed'
            ],
            [
                'es' => [
                    'name' => 'Coordinación'
                ],
                'en' => [
                    'name' => 'Coordination'
                ],
                'code' => 'coordination'
            ],
            [
                'es' => [
                    'name' => 'Agilidad'
                ],
                'en' => [
                    'name' => 'Agility'
                ],
                'code' => 'agility'
            ],
            [
                'es' => [
                    'name' => 'Relajación'
                ],
                'en' => [
                    'name' => 'Relaxation'
                ],
                'code' => 'relaxation'
            ],
            [
                'es' => [
                    'name' => 'Predeportes'
                ],
                'en' => [
                    'name' => 'Presports'
                ],
                'code' => 'presports'
            ],
            [
                'es' => [
                    'name' => 'Deportes individuales'
                ],
                'en' => [
                    'name' => 'Individual sports'
                ],
                'code' => 'individual_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes de raqueta'
                ],
                'en' => [
                    'name' => 'Racket sports'
                ],
                'code' => 'racket_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes de combate'
                ],
                'en' => [
                    'name' => 'Fighting sports'
                ],
                'code' => 'fighting_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes de equipo'
                ],
                'en' => [
                    'name' => 'Team sports'
                ],
                'code' => 'team_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes alternativos'
                ],
                'en' => [
                    'name' => 'Alternative sports'
                ],
                'code' => 'alternative_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes adaptados'
                ],
                'en' => [
                    'name' => 'Adapted sports'
                ],
                'code' => 'adapted_sports'
            ],
            [
                'es' => [
                    'name' => 'Deportes acuáticos'
                ],
                'en' => [
                    'name' => 'Water sports'
                ],
                'code' => 'water_sports'
            ],
            [
                'es' => [
                    'name' => 'Juegos de presentación'
                ],
                'en' => [
                    'name' => 'Presentation games'
                ],
                'code' => 'presentation_games'
            ],
            [
                'es' => [
                    'name' => 'Juegos tradicionales'
                ],
                'en' => [
                    'name' => 'Traditional games'
                ],
                'code' => 'Traditional_games'
            ],
            [
                'es' => [
                    'name' => 'Juegos de locomoción'
                ],
                'en' => [
                    'name' => 'Motor games'
                ],
                'code' => 'motor_games'
            ],
            [
                'es' => [
                    'name' => 'Juegos de equilibrio'
                ],
                'en' => [
                    'name' => 'Balance games '
                ],
                'code' => 'balance_games '
            ],
            [
                'es' => [
                    'name' => 'Juegos de lanzamiento'
                ],
                'en' => [
                    'name' => 'Throwing games '
                ],
                'code' => 'throwing_games '
            ],            [
                'es' => [
                    'name' => 'Juegos de salto'
                ],
                'en' => [
                    'name' => 'Jumping games '
                ],
                'code' => 'jumping_games '
            ],            [
                'es' => [
                    'name' => 'Juegos sensoriales'
                ],
                'en' => [
                    'name' => 'Sensory games '
                ],
                'code' => 'sensory_games '
            ],            
            [
                'es' => [
                    'name' => 'Juegos de fuerza'
                ],
                'en' => [
                    'name' => 'Strength games'
                ],
                'code' => 'strength_games'
            ],           
            [
                'es' => [
                    'name' => 'Juegos cognitivos'
                ],
                'en' => [
                    'name' => 'Brain games '
                ],
                'code' => 'brain_games '
            ],            
            [
                'es' => [
                    'name' => 'Expresión corporal'
                ],
                'en' => [
                    'name' => 'Body language'
                ],
                'code' => 'body_language'
            ],            
            [
                'es' => [
                    'name' => 'Danza'
                ],
                'en' => [
                    'name' => 'Dance'
                ],
                'code' => 'dance'
            ],            
            [
                'es' => [
                    'name' => 'Acrosport'
                ],
                'en' => [
                    'name' => 'Acrosport'
                ],
                'code' => 'acrosport'
            ],            
            [
                'es' => [
                    'name' => 'Actividades en el medio natural'
                ],
                'en' => [
                    'name' => 'Natural environment activities'
                ],
                'code' => 'Natural_environment_activities'
            ],            
            [
                'es' => [
                    'name' => 'Malabares'
                ],
                'en' => [
                    'name' => 'Juggle'
                ],
                'code' => 'juggle'
            ],            
            [
                'es' => [
                    'name' => 'Nuevas tecnologías'
                ],
                'en' => [
                    'name' => 'New technologies'
                ],
                'code' => 'new_technologies'
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
        $this->createExerciseContentBlocks($this->get()->current());
    }
}
