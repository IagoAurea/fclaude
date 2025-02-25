<?php

namespace Modules\Club\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Club\Entities\AcademicPeriod;
use Modules\Club\Entities\AcademicYear;

class AcademicPeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicPeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->firstName(),
            'academic_year_id' => 11,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date()
        ];
    }
}
