<?php

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Test\Repositories\Interfaces\ConfigurationRepositoryInterface;

class ConfigurationTableSeeder extends Seeder
{

    /**
     * @var object
     */
    protected $configRepository;

    public function __construct(ConfigurationRepositoryInterface $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @return void
     */
    protected function createConfiguration(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->configRepository->create($elm);
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
                    'name' => 'Nueva puntuación',
                    'description' => 'Nueva puntuación'
                ],
                'en' => [
                    'name' => 'New Score',
                    'description' => 'New Score'
                ],
                'code'           => 'new_score'
            ],
            [
                'es' => [
                    'name' => 'Mejor Marca positiva',
                    'description' => 'Mejor Marca positiva'
                ],
                'en' => [
                    'name' => 'Best positive mark',
                    'description' => 'Best Positive Brand'
                ],
                'code'           => 'score_positive'
            ],
            [
                'es' => [
                    'name' => 'Mejor Marca negativo',
                    'description' => 'Mejor Marca negativa'
                ],
                'en' => [
                    'name' => 'Best Negative mark',
                    'description' => 'Best Negative Brand'
                ],
                'code'           => 'score_negative'
            ],
            [
                'es' => [
                    'name' => 'Cálculo de media',
                    'description' => 'Cálculo de media'
                ],
                'en' => [
                    'name' => 'Average calculation',
                    'description' => 'Average calculation'
                ],
                'code'           => 'average'
            ],
            [
                'es' => [
                    'name' => 'Cálculo de mediana',
                    'description' => 'Cálculo de mediana'
                ],
                'en' => [
                    'name' => 'Median calculation',
                    'description' => 'Median calculation'
                ],
                'code'           => 'median'
            ],
            [
                'es' => [
                    'name' => 'Tabla comparativa',
                    'description' => 'Tabla comparativa'
                ],
                'en' => [
                    'name' => 'Comparison chart',
                    'description' => 'Comparison chart'
                ],
                'code'           => 'chart',
                'is_table'  => true
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
        $this->createConfiguration($this->get()->current());
    }

}
