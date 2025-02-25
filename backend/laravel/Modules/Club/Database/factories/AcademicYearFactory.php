<?php

namespace Modules\Club\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Club\Entities\AcademicYear;

class AcademicYearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicYear::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->firstName(),
            'club_id' => 11,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'is_active' => true
        ];
    }
}
