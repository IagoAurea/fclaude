<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Entities\Teacher;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $club_id = 11;
        $genders = ['m', 'f'];
        $name = $this->faker->firstName();
        $gender = $genders[ceil(random_int(0, 1))]; // random gender
        $alias = $this->faker->firstName();
        $date_of_birth = $this->faker->dateTimeBetween('-40 years', '-15 years')->format('Y-m-d'); // Y-m-d
        $citizenship = $this->faker->city();

        return [
            'club_id' => $club_id,
            'name' => $name,
            'gender' => $gender,
            'alias' => $alias,
            'date_of_birth' => $date_of_birth,
            'citizenship' => $citizenship,
        ];
    }
}
