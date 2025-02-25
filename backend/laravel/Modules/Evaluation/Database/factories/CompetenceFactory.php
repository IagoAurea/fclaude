<?php

namespace Modules\Evaluation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Evaluation\Entities\Competence;
use Illuminate\Support\Str;

class CompetenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName();

        return [
            'en' => [
                'name' => $name,
                'acronym' => Str::slug($name, '_')
            ]
        ];
    }
}
