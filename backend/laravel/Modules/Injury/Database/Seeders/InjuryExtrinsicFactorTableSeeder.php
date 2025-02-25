<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\InjuryExtrinsicFactorRepositoryInterface;

class InjuryExtrinsicFactorTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injuryExtrinsicFactorRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(InjuryExtrinsicFactorRepositoryInterface $injuryExtrinsicFactorRepository)
    {
        $this->injuryExtrinsicFactorRepository = $injuryExtrinsicFactorRepository;
    }

    /**
     * @return void
     */
    protected function createInjuryExtrinsicFactors(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->injuryExtrinsicFactorRepository->create($elm);
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
                    'name' => 'Arbitraje'
                ],
                'en' => [
                    'name' => 'Arbitration'
                ],
                'code' => 'arbitration'
            ],
            [
                'es' => [
                    'name' => 'Reglas de juego'
                ],
                'en' => [
                    'name' => 'Game rules'
                ],
                'code' => 'game_rules'
            ],
            [
                'es' => [
                    'name' => 'Entrenamiento'
                ],
                'en' => [
                    'name' => 'Training'
                ],
                'code' => 'training'
            ],
            [
                'es' => [
                    'name' => 'Falta de comunicación'
                ],
                'en' => [
                    'name' => 'Lack of communication'
                ],
                'code' => 'lack_of_communication'
            ],
            [
                'es' => [
                    'name' => 'Protección deportiva'
                ],
                'en' => [
                    'name' => 'Sports protection'
                ],
                'code' => 'sports_protection'
            ],
            [
                'es' => [
                    'name' => 'Equipamiento deportivo'
                ],
                'en' => [
                    'name' => 'Sports equipment'
                ],
                'code' => 'sports_equipment'
            ],
            [
                'es' => [
                    'name' => 'Ambiente'
                ],
                'en' => [
                    'name' => 'Environment'
                ],
                'code' => 'environment'
            ],
            [
                'es' => [
                    'name' => 'Superficie de juego'
                ],
                'en' => [
                    'name' => 'Playing surface'
                ],
                'code' => 'playing_surface'
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
        $this->createInjuryExtrinsicFactors($this->get()->current());
    }
}
