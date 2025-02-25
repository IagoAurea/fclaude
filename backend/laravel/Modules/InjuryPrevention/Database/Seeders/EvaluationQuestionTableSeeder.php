<?php

namespace Modules\InjuryPrevention\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\InjuryPrevention\Repositories\Interfaces\EvaluationQuestionRepositoryInterface;

class EvaluationQuestionTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $evaluationQuestionRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(EvaluationQuestionRepositoryInterface $evaluationQuestionRepository)
    {
        $this->evaluationQuestionRepository = $evaluationQuestionRepository;
    }

    /**
     * @return void
     */
    protected function createEvaluationQuestion(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->evaluationQuestionRepository->create($elm);
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
                    'name' => 'Comunicación con jugador y entre STAFF'
                ],
                'en' => [
                    'name' => 'Communication with player and between STAFF'
                ],
                'code' => 'player_comunication'
            ],
            [
                'es' => [
                    'name' => 'Filosofía del club y entrenador'
                ],
                'en' => [
                    'name' => 'Club and coach philosophy'
                ],
                'code' => 'club_philosophy'
            ],
            [
                'es' => [
                    'name' => 'Estrategias de recuperación'
                ],
                'en' => [
                    'name' => 'Recovery strategies'
                ],
                'code' => 'recovery_strategies'
            ],
            [
                'es' => [
                    'name' => 'Protocolos de prevención específicos'
                ],
                'en' => [
                    'name' => 'Specific prevention protocols'
                ],
                'code' => 'prevention_protocols'
            ],
            [
                'es' => [
                    'name' => 'Test de control'
                ],
                'en' => [
                    'name' => 'Control test'
                ],
                'code' => 'control_test'
            ],
            [
                'es' => [
                    'name' => 'Control de la condición física del jugador'
                ],
                'en' => [
                    'name' => "Player's physical condition monitoring"
                ],
                'code' => 'player_physical_monitoring'
            ],
            [
                'es' => [
                    'name' => 'Control de la carga de entrenamiento'
                ],
                'en' => [
                    'name' => 'Training load control'
                ],
                'code' => 'training_load_control'
            ],
            [
                'es' => [
                    'name' => 'Control clínico de la lesión'
                ],
                'en' => [
                    'name' => 'Clinical monitoring of the injury'
                ],
                'code' => 'injury_clinical_monitoring'
            ],
            [
                'es' => [
                    'name' => 'Control de la nutrición'
                ],
                'en' => [
                    'name' => "Nutrition control"
                ],
                'code' => 'nutrition_control'
            ],
            [
                'es' => [
                    'name' => 'Buena adherencia del jugador'
                ],
                'en' => [
                    'name' => "Player's good adherence"
                ],
                'code' => 'good_adherence'
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
        $this->createEvaluationQuestion($this->get()->current());
    }
}
