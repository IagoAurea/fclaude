<?php

namespace Modules\Qualification\Database\factories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Qualification\Entities\Qualification;

class QualificationFactory extends Factory
{
    use HasFactory;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Qualification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $classroom_academic_year_id = ClassroomAcademicYear::factory();

        return [
            'classroom_academic_year_id' => $classroom_academic_year_id,
            'classroom_academic_period_id' => 1,
            'title' => $this->faker->name(),
            'description' => $this->faker->text()
        ];
    }
}
