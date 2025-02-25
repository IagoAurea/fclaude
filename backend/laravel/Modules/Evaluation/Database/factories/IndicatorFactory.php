<?php

namespace Modules\Evaluation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Evaluation\Entities\Indicator;

class IndicatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Indicator::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName();

        return [
            'name' => $name,
            'acronym' => Str::slug($name, '_'),
            'percentage' => '10',
            'evaluation_criteria' => $this->faker->text(30),
            'insufficient_caption' => $this->faker->text(30),
            'sufficient_caption' => $this->faker->text(30),
            'remarkable_caption' => $this->faker->text(30),
            'outstanding_caption' => $this->faker->text(30)
        ];
    }
}
