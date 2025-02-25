<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\InjuryIntrinsicFactorRepositoryInterface;

class InjuryIntrinsicFactorTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injuryIntrinsicFactorRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(InjuryIntrinsicFactorRepositoryInterface $injuryIntrinsicFactorRepository)
    {
        $this->injuryIntrinsicFactorRepository = $injuryIntrinsicFactorRepository;
    }

    /**
     * @return void
     */
    protected function createInjuryIntrinsicFactors(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->injuryIntrinsicFactorRepository->create($elm);
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
                    'name' => 'Edad'
                ],
                'en' => [
                    'name' => 'Age'
                ],
                'code' => 'age'
            ],
            [
                'es' => [
                    'name' => 'Historial lesional'
                ],
                'en' => [
                    'name' => 'Injury history'
                ],
                'code' => 'history'
            ],
            [
                'es' => [
                    'name' => 'Mala rehabilitación'
                ],
                'en' => [
                    'name' => 'Bad rehabilitation'
                ],
                'code' => 'bad_rehabilitation'
            ],
            [
                'es' => [
                    'name' => 'Sexo'
                ],
                'en' => [
                    'name' => 'Sex'
                ],
                'code' => 'sex'
            ],
            [
                'es' => [
                    'name' => 'Composición corporal'
                ],
                'en' => [
                    'name' => 'Body composition'
                ],
                'code' => 'body_composition'
            ],
            [
                'es' => [
                    'name' => 'Inestabilidades articulares'
                ],
                'en' => [
                    'name' => 'Joint instabilities'
                ],
                'code' => 'joint_instabilities'
            ],
            [
                'es' => [
                    'name' => 'Mala condición física'
                ],
                'en' => [
                    'name' => 'Bad physical condition'
                ],
                'code' => 'bad_physical_condition'
            ],
            [
                'es' => [
                    'name' => 'Mala nutrición'
                ],
                'en' => [
                    'name' => 'Poor nutrition'
                ],
                'code' => 'poor_nutrition'
            ],
            [
                'es' => [
                    'name' => 'Alteraciones del sueño'
                ],
                'en' => [
                    'name' => 'Sleep disturbances'
                ],
                'code' => 'sleep_disturbances'
            ],
            [
                'es' => [
                    'name' => 'Estrés'
                ],
                'en' => [
                    'name' => 'Stress'
                ],
                'code' => 'stress'
            ],
            [
                'es' => [
                    'name' => 'Fátiga'
                ],
                'en' => [
                    'name' => 'Fatigue'
                ],
                'code' => 'fatigue'
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
        $this->createInjuryIntrinsicFactors($this->get()->current());
    }
}
