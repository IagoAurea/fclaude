<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\PhysicalProblemRepositoryInterface;

class PhysicalProblemsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $physicalRepository;

    public function __construct(PhysicalProblemRepositoryInterface $physicalRepository)
    {
        $this->physicalRepository = $physicalRepository;
    }

    /**
     * @return void
     */
    protected function createPhysicalExertionProblem(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->physicalRepository->create($elm);
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
                    'name' => 'Dolor'
                ],
                'en' => [
                    'name' => 'Pain'
                ],
                'code' => 'pain'
            ],
            [
                'es' => [
                    'name' => 'Mareo'
                ],
                'en' => [
                    'name' => 'Dizziness'
                ],
                'code' => 'dizziness'
            ],
            [
                'es' => [
                    'name' => 'Desmayo'
                ],
                'en' => [
                    'name' => 'Fainting'
                ],
                'code' => 'fainting'
            ],
            [
                'es' => [
                    'name' => 'Alteraciones del sueño'
                ],
                'en' => [
                    'name' => 'Sleep disturbancesr'
                ],
                'code' => 'sleep_disturbances'
            ],
            [
                'es' => [
                    'name' => 'Alteraciones de la menstruación'
                ],
                'en' => [
                    'name' => 'Alterations in menstruation'
                ],
                'code' => 'alterations_menstruation'
            ],
            [
                'es' => [
                    'name' => 'Alteraciones de la respiración'
                ],
                'en' => [
                    'name' => 'Breathing alterations'
                ],
                'code' => 'breathing_alterations'
            ],
            [
                'es' => [
                    'name' => 'Afectación del sistema inmune'
                ],
                'en' => [
                    'name' => 'Immune system involvement'
                ],
                'code' => 'immune_system_involvement'
            ],
            [
                'es' => [
                    'name' => 'Otros'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
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
        $this->createPhysicalExertionProblem($this->get()->current());
    }
}
