<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Training\Repositories\Interfaces\TrainingPeriodRepositoryInterface;

class TrainingPeriodsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $trainingPeriodRepository;

    public function __construct(TrainingPeriodRepositoryInterface $trainingPeriodRepository)
    {
        $this->trainingPeriodRepository = $trainingPeriodRepository;
    }

    /**
     * @return void
     */
    protected function createTrainingPeriod(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->trainingPeriodRepository->create($elm);
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
                    'name' => 'Preparatorio'
                ],
                'en' => [
                    'name' => 'Preparatory'
                ],
                'code' => 'preparatory'
            ],
            [
                'es' => [
                    'name' => 'Temporada'
                ],
                'en' => [
                    'name' => 'Season'
                ],
                'code' => 'season'
            ],
            [
                'es' => [
                    'name' => 'Transición'
                ],
                'en' => [
                    'name' => 'Transition'
                ],
                'code' => 'transition'
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
        $this->createTrainingPeriod($this->get()->current());
    }
}
