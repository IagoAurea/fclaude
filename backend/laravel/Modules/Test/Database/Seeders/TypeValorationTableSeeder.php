<?php

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Test\Repositories\Interfaces\TypeValorationRepositoryInterface;

class TypeValorationTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $typeValorationRepository;

    public function __construct(TypeValorationRepositoryInterface $typeValorationRepository)
    {
        $this->typeValorationRepository = $typeValorationRepository;
    }

    /**
     * @return void
     */
    protected function createTypeValoration(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->typeValorationRepository->create($elm);
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
                    'name' => 'Porcentual'
                ],
                'en' => [
                    'name' => 'Percentage'
                ],
                'code'           => 'percentage'
            ],
            [
                'es' => [
                    'name' => 'Puntos'
                ],
                'en' => [
                    'name' => 'Points'
                ],
                'code'           => 'points'
            ],
            [
                'es' => [
                    'name' => 'Comparación de peso'
                ],
                'en' => [
                    'name' => 'Weight comparison'
                ],
                'code'           => 'weight'
            ],
            [
                'es' => [
                    'name' => 'Comparación aumento/disminución Medidas'
                ],
                'en' => [
                    'name' => 'Comparison increase / decrease Measurements'
                ],
                'code'           => 'measurement'
            ],
            [
                'es' => [
                    'name' => 'Nueva puntuación'
                ],
                'en' => [
                    'name' => 'new score'
                ],
                'code'           => 'new_score'
            ],
            [
                'es' => [
                    'name' => 'Diferencia simétrica'
                ],
                'en' => [
                    'name' => 'Symmetric difference'
                ],
                'code'           => 'symmetric_difference'
            ],
            [
                'es' => [
                    'name' => 'Cualitativa'
                ],
                'en' => [
                    'name' => 'Qualitative'
                ],
                'code'           => 'qualitative'
            ],
            [
                'es' => [
                    'name' => 'Promedio de items'
                ],
                'en' => [
                    'name' => 'Average Items'
                ],
                'code'           => 'average_item'
            ],
            [
                'es' => [
                    'name' => 'Promedio simétrico'
                ],
                'en' => [
                    'name' => 'Average Symmetric'
                ],
                'code'           => 'average_symmetric'
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
        $this->createTypeValoration($this->get()->current());
    }

}
