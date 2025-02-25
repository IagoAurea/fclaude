<?php

namespace Modules\Calculator\Database\Seeders\InjuryPrevention;

use Illuminate\Database\Seeder;
use Modules\InjuryPrevention\Entities\InjuryPrevention;

// Repositories
use Modules\Calculator\Repositories\Interfaces\CalculatorItemRepositoryInterface;

class CalculatorItemsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $calculatorItemRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(CalculatorItemRepositoryInterface $calculatorItemRepository)
    {
        $this->calculatorItemRepository = $calculatorItemRepository;
    }

    /**
     * @return void
     */
    protected function createCalculatorInjuryPreventionItems(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->calculatorItemRepository->create($elm);
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
                'code' => 'calc_age',
                'calculation_var' => '$age',
                'percentage' => 0.5,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => false,
            ],
            [
                'es' => [
                    'name' => 'Número lesiones último año'
                ],
                'en' => [
                    'name' => 'Number of last year lessons'
                ],
                'code' => 'lessons_number',
                'percentage' => 0.5,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Número de recidivas (recaidas)'
                ],
                'en' => [
                    'name' => 'Number of relapses'
                ],
                'code' => 'relapses_number',
                'percentage' => 0.5,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Estado de condición física'
                ],
                'en' => [
                    'name' => 'State of physical condition'
                ],
                'code' => 'physical_state',
                'percentage' => 0.5,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Programa preventivo de lesiones'
                ],
                'en' => [
                    'name' => 'Injury prevention program'
                ],
                'code' => 'injury_prevention',
                'percentage' => 0.5,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Nutrición'
                ],
                'en' => [
                    'name' => 'Nutrition'
                ],
                'code' => 'nutrition',
                'percentage' => 0.2,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Nivel de estrés'
                ],
                'en' => [
                    'name' => 'Stress level'
                ],
                'code' => 'stress_level',
                'percentage' => 0.2,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Fatiga'
                ],
                'en' => [
                    'name' => 'Fatigue'
                ],
                'code' => 'fatigue',
                'percentage' => 0.2,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Sueño'
                ],
                'en' => [
                    'name' => 'Sleep'
                ],
                'code' => 'sleep',
                'percentage' => 0.2,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Carga de entrenamiento'
                ],
                'en' => [
                    'name' => 'Training load'
                ],
                'code' => 'training_load',
                'percentage' => 0.3,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
            ],
            [
                'es' => [
                    'name' => 'Competición / semana '
                ],
                'en' => [
                    'name' => 'Competition per week'
                ],
                'code' => 'week_comp',
                'percentage' => 0.3,
                'entity_class' => InjuryPrevention::class,
                'is_visible' => true,
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
        $this->createCalculatorInjuryPreventionItems($this->get()->current());
    }
}
