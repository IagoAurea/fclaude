<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\TobaccoConsumptionRepositoryInterface;

class TobaccoConsumptionsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $tobaccoConsumptionRepository;

    public function __construct(TobaccoConsumptionRepositoryInterface $tobaccoConsumptionRepository)
    {
        $this->tobaccoConsumptionRepository = $tobaccoConsumptionRepository;
    }

    /**
     * @return void
     */
    protected function createTobaccoConsumption(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->tobaccoConsumptionRepository->create($elm);
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
                    'name' => 'No fuma, pero antes sí'
                ],
                'en' => [
                    'name' => "Not currently, but used to in the past"
                ],
                'code' => 'not_smoke_used'
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
                    'name' => 'Diariamente'
                ],
                'en' => [
                    'name' => 'Daily'
                ],
                'code' => 'daily'
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
        $this->createTobaccoConsumption($this->get()->current());
    }
}
