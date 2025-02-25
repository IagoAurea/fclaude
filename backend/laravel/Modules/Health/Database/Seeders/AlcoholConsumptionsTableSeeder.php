<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\AlcoholConsumptionRepositoryInterface;

class AlcoholConsumptionsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $alcoholConsumptionRepository;

    public function __construct(AlcoholConsumptionRepositoryInterface $alcoholConsumptionRepository)
    {
        $this->alcoholConsumptionRepository = $alcoholConsumptionRepository;
    }

    /**
     * @return void
     */
    protected function createAlcoholConsumption(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->alcoholConsumptionRepository->create($elm);
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
                    'name' => 'Nunca'
                ],
                'en' => [
                    'name' => 'Never'
                ],
                'code' => 'never'
            ],
            [
                'es' => [
                    'name' => 'Ocasionalmente'
                ],
                'en' => [
                    'name' => 'Occasionally'
                ],
                'code' => 'occasionally'
            ],
            [
                'es' => [
                    'name' => 'Consumo moderado'
                ],
                'en' => [
                    'name' => 'Moderate consumption'
                ],
                'code' => 'moderate_consumption'
            ],
            [
                'es' => [
                    'name' => 'Consumo alto'
                ],
                'en' => [
                    'name' => 'High consumption'
                ],
                'code' => 'high_consumption'
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
        $this->createAlcoholConsumption($this->get()->current());
    }
}
