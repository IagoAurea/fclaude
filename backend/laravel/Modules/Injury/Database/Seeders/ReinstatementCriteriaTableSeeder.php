<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\ReinstatementCriteriaRepositoryInterface;

class ReinstatementCriteriaTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $reinstatementRepository;

    public function __construct(ReinstatementCriteriaRepositoryInterface $reinstatementRepository)
    {
        $this->reinstatementRepository = $reinstatementRepository;
    }

    /**
     * @return void
     */
    protected function createReinstatementCriteria(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->reinstatementRepository->create($elm);
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
                    'name' => 'Valoración positiva del staff para la reincorporación'
                ],
                'en' => [
                    'name' => 'Positive assessment of the staff for reinstatement'
                ],
                'code'           => 'staff_positive'
            ],
            [
                'es' => [
                    'name' => 'Tests de control superados'
                ],
                'en' => [
                    'name' => 'Control tests passed'
                ],
                'code'           => 'test_passed'
            ],

            [
                'es' => [
                    'name' => 'Momento de la temporada apropiado'
                ],
                'en' => [
                    'name' => 'Appropriate time of season'
                ],
                'code'           => 'season_time'
            ],
            [
                'es' => [
                    'name' => 'Inexistencia de conflicto de intereses'
                ],
                'en' => [
                    'name' => 'Non-existence of conflict of interest'
                ],
                'code'           => 'not_conflict'
            ],
            [
                'es' => [
                    'name' => 'Lesión no enmascarada con ayuda farmacológica'
                ],
                'en' => [
                    'name' => 'Lesion not masked with pharmacological help'
                ],
                'code'           => 'lesion_masked'
            ],
            [
                'es' => [
                    'name' => 'Deportista satisfecho con la desición tomada'
                ],
                'en' => [
                    'name' => 'Athlete satisfied with the decision taken'
                ],
                'code'           => 'athlete_satisfied'
            ],
            [
                'es' => [
                    'name' => 'La adherencia del jugador al proceso ha sido adecuada'
                ],
                'en' => [
                    'name' => 'The players adherence to the process has been adequate'
                ],
                'code'           => 'athlete_adherence'
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
        $this->createReinstatementCriteria($this->get()->current());
    }
}
