<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Entities\Age;
use Modules\Classroom\Entities\Classroom;
use Modules\Classroom\Entities\Subject;
use Modules\Classroom\Entities\Teacher;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $club_id = 11; // temporal
        $name = $this->faker->firstName();
        $age_id = Age::factory()->create()->id;

        return [
            'club_id' => $club_id,
            'name' => $name,
            'age_id' => $age_id,
            'color' => $this->faker->hexColor
        ];
    }
}
