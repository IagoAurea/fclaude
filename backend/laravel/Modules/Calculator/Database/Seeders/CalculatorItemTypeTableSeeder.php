<?php

namespace Modules\Calculator\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\Calculator\Repositories\Interfaces\CalculatorItemTypeRepositoryInterface;

class CalculatorItemTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $calculatorItemTypeRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(CalculatorItemTypeRepositoryInterface $calculatorItemTypeRepository)
    {
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
    }

    /**
     * @return void
     */
    protected function createCalculatorItemTypes(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->calculatorItemTypeRepository->create($elm);
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
                    'name' => 'Bajo'
                ],
                'en' => [
                    'name' => 'Low'
                ],
                'code' => 'low',
                'color' => '#00E9C5',
                'range_min' => 0,
                'range_max' => 6.5
            ],
            [
                'es' => [
                    'name' => 'Medio'
                ],
                'en' => [
                    'name' => 'Medium'
                ],
                'code' => 'medium',
                'color' => '#C8DF00',
                'range_min' => 6.5,
                'range_max' => 9.1
            ],
            [
                'es' => [
                    'name' => 'Alto'
                ],
                'en' => [
                    'name' => 'High'
                ],
                'code' => 'high',
                'color' => '#F92F28',
                'range_min' => 9.1,
                'range_max' => 11.7
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
        $this->createCalculatorItemTypes($this->get()->current());
    }
}
