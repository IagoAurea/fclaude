<?php

namespace Modules\Evaluation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Evaluation\Entities\Rubric;

class RubricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rubric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName()
        ];
    }
}
