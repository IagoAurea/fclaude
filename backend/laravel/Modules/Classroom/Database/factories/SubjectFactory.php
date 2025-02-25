<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Entities\Subject;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $code = $this->faker->randomNumber(8);

        return [
            'code' => $code
        ];
    }
}
