<?php

namespace Modules\Classroom\Database\Factories;

use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Evaluation\Entities\Rubric;

class ClassroomAcademicYearRubricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassroomAcademicYearRubric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $classroom_academic_year = ClassroomAcademicYear::factory()->create();
        $rubric = Rubric::factory()->create();

        return [
            'classroom_academic_year_id' => $classroom_academic_year->id,
            'evaluation_date' => $this->faker->date(),
            'rubric_id' => $rubric->id,
        ];
    }
}
