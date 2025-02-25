<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\PhaseRepositoryInterface;

class PhaseTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $phaseRepository;

    public function __construct(PhaseRepositoryInterface $phaseRepository)
    {
        $this->phaseRepository = $phaseRepository;
    }

    /**
     * @return void
     */
    protected function createPhase(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->phaseRepository->create($elm);
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
                    'name' => 'EVOLUCIÓN PSICOLÓGICA'
                ],
                'en' => [
                    'name' => 'PSYCHOLOGICAL EVOLUTION'
                ],
                'code'           => 'psychological',
                'test_code'          => 'valoration_psychological',
                'percentage_value' => 0,
                'min_percentage_pass' => 40
            ],
            [
                'es' => [
                    'name' => 'RECUPERACIÓN FUNCIONAL'
                ],
                'en' => [
                    'name' => 'FUNCTIONAL RECOVERY'
                ],
                'code'           => 'recovery',
                'test_code'          => 'valoration_recovery',
                'percentage_value' => 30,
                'min_percentage_pass' => 85
            ],
            [
                'es' => [
                    'name' => 'READAPTACIÓN FÍSICO DEPORTIVA'
                ],
                'en' => [
                    'name' => 'PHYSICAL SPORTS READAPTATION'
                ],
                'code'           => 'valoration_readaptation',
                'test_code'          => 'valoration_readaptation',
                'percentage_value' => 30,
                'min_percentage_pass' => 85
            ],
            [
                'es' => [
                    'name' => 'REENTRENAMIENTO'
                ],
                'en' => [
                    'name' => 'RE-TRAINING'
                ],
                'code'           => 'retraining',
                'test_code'          => 'valoration_retraining',
                'percentage_value' => 30,
                'min_percentage_pass' => 85
            ],
            [
                'es' => [
                    'name' => 'REINCORPORACIÓN AL ENTRENAMIENTO'
                ],
                'en' => [
                    'name' => 'REINCORPORATION TO TRAINING '
                ],
                'code'               => 'reincorporation',
                'test_code'          => 'valoration_reincorporation',
                'percentage_value' => 5,
                'min_percentage_pass' => 85
            ],
            [
                'es' => [
                    'name' => 'REINCORPORACIÓN A LA COMPETICIÓN ',
                ],
                'en' => [
                    'name' => 'REINCORPORATION TO COMPETITION',
                ],
                'code'              => 'reincor_competition',
                'test_code'         => 'valor_reincor_competition',
                'percentage_value' => 5,
                'min_percentage_pass' => 85
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
        $this->createPhase($this->get()->current());
    }
}
