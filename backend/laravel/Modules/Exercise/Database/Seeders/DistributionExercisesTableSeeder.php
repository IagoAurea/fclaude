<?php

namespace Modules\Exercise\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Exercise\Repositories\Interfaces\DistributionExerciseRepositoryInterface;

class DistributionExercisesTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $distributionRepository;

    public function __construct(DistributionExerciseRepositoryInterface $distributionRepository)
    {
        $this->distributionRepository = $distributionRepository;
    }

    /**
     * @return void
     */
    protected function createDistributionExercise(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->distributionRepository->create($elm);
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
                    'name' => 'Individual'
                ],
                'en' => [
                    'name' => 'Individual'
                ],
                'code' => 'individual'
            ],
            [
                'es' => [
                    'name' => 'Grupal'
                ],
                'en' => [
                    'name' => 'Group'
                ],
                'code' => 'group'
            ],
            [
                'es' => [
                    'name' => 'Colectiva'
                ],
                'en' => [
                    'name' => 'Collective'
                ],
                'code' => 'collective'
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
        $this->createDistributionExercise($this->get()->current());
    }
}
