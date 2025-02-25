<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Entities\Classroom;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Modules\Club\Entities\AcademicYear;

class ClassroomAcademicYearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassroomAcademicYear::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $academic_year = AcademicYear::factory()->create();
        $classroom = Classroom::factory()->create();

        return [
            'academic_year_id' => $academic_year->id,
            'classroom_id' => $classroom->id
        ];
    }
}
