<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Entities\Age;

class AgeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Age::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $range = $this->faker->firstName();

        return [
            'range' => $range,
        ];
    }
}
