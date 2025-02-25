<?php

namespace Modules\Qualification\Database\factories;

use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use Modules\Qualification\Entities\QualificationItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Club\Entities\AcademicPeriod;
use Modules\Club\Entities\AcademicYear;
use Modules\Qualification\Entities\Qualification;

class QualificationItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QualificationItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $classroom_rubric = ClassroomAcademicYearRubric::factory()->create();
        $academic_year_id = $classroom_rubric->classroomsAcademicYear->academic_year_id;
        $qualification = Qualification::factory()->create([
            'classroom_academic_year_id' => $classroom_rubric->classroom_academic_year_id,
            'classroom_academic_period_id' => 1,
        ]);
        $academic_period = AcademicPeriod::factory()->create([
            'academic_year_id' => $academic_year_id
        ]);

        return [
            'qualification_id' => $qualification->id,
            'classroom_rubric_id' => $classroom_rubric->id,
            'percentage' => 100,
            'status' => 1,
        ];
    }
}
