<?php

namespace Modules\Calculator\Database\Seeders\InjuryPrevention;

use Illuminate\Database\Seeder;
use Modules\InjuryPrevention\Entities\InjuryPrevention;

// Repositories
use Modules\Calculator\Repositories\Interfaces\CalculatorItemRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorItemTypeRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityItemPointValueRepositoryInterface;

class OptionPointTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $calculatorItemRepository;

    /**
     * @var object
     */
    protected $calculatorItemTypeRepository;

    /**
     * @var object
     */
    protected $calculatorEntityItemPointRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        CalculatorItemRepositoryInterface $calculatorItemRepository,
        CalculatorItemTypeRepositoryInterface $calculatorItemTypeRepository,
        CalculatorEntityItemPointValueRepositoryInterface $calculatorEntityItemPointRepository
    ) {
        $this->calculatorItemRepository = $calculatorItemRepository;
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
        $this->calculatorEntityItemPointRepository = $calculatorEntityItemPointRepository;
    }

    /**
     * @return \Iterator
     */
    private function getCalculatorItemPoints($itemCode)
    {
        $items = [
            'calc_age' => [
                'low' => [
                    'condition' => 'return $age <= 20 ? true : false;',
                    'title' => '≤ 2',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => 'return $age > 20 && $age < 30 ? true : false;',
                    'title' => '21 - 29',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => 'return $age >= 30 ? true : false;',
                    'title' => '≥ 30',
                    'points' => 3,
                ],
            ],
            'lessons_number' => [
                'low' => [
                    'condition' => null,
                    'title' => '0',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => '1 - 2',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => '> 2',
                    'title' => '> 2',
                    'points' => 3,
                ],
            ],
            'relapses_number' => [
                'low' => [
                    'condition' => null,
                    'title' => '0',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => '1',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => '> 1',
                    'points' => 3,
                ],
            ],
            'physical_state' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Óptimo',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => 'Bueno',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'Malo',
                    'points' => 3,
                ],
            ],
            'injury_prevention' => [
                'low' => [
                    'condition' => null,
                    'title' => '> 1 Día / semana',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => '1 Día / semana',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'No',
                    'points' => 3,
                ],
            ],
            'nutrition' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Excelente',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => 'Buena',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'Escasa',
                    'points' => 3
                ],
            ],
            'stress_level' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Relajado',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => 'Normal',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'Estresado',
                    'points' => 3
                ],
            ],
            'fatigue' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Recuperado',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => 'Normal',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'Fatigado',
                    'points' => 3
                ],
            ],
            'sleep' => [
                'low' => [
                    'condition' => null,
                    'title' => '> 8 horas',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => '6 - 8 horas',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => '< 6 horas',
                    'points' => 3
                ],
            ],
            'training_load' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Baja',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => 'Media',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => 'Alta',
                    'points' => 3,
                ],
            ],
            'week_comp' => [
                'low' => [
                    'condition' => null,
                    'title' => 'Ninguna',
                    'points' => 1,
                ],
                'medium' => [
                    'condition' => null,
                    'title' => '1',
                    'points' => 2,
                ],
                'high' => [
                    'condition' => null,
                    'title' => '≥ 2',
                    'points' => 3,
                ],
            ],
        ];

        return $items[$itemCode];
    }

    /**
     * 
     */
    private function createCalculatorInjuryPreventionPointItems()
    {
        // Find all calculation items depending on the seeding class
        $items = $this->calculatorItemRepository->findBy([
            'entity_class' => InjuryPrevention::class,
        ]);

        // Get the array of all item types
        $itemPointTypes = $this->calculatorItemTypeRepository->findAll();

        // Start looping through all the main items retrieved
        foreach ($items as $item) {

            // Get the point values depending on the item code (low, medium, high)
            $itemPointValues = $this->getCalculatorItemPoints($item->code);

            // Loop through all the item point value settings
            foreach ($itemPointTypes as $pointType) {
                // Get the specific values for the point type
                $itemValues = $itemPointValues[$pointType->code];

                // Add the values to the pointing type
                $itemValues['calculator_item_id'] = $item->id;
                $itemValues['calculator_item_type_id'] = $pointType->id;

                // Save the information
                $this->calculatorEntityItemPointRepository->create($itemValues);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCalculatorInjuryPreventionPointItems();
    }
}
