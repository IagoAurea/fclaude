<?php

namespace Modules\Qualification\Database\Seeders;

use Modules\Qualification\Entities\QualificationItem;
use Modules\Qualification\Entities\Qualification;
use App\Services\BaseSeeder;
use Faker\Factory;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use Modules\Club\Entities\AcademicPeriod;
use Modules\Club\Entities\AcademicYear;

class QualificationTableSeeder extends BaseSeeder
{
    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;
    /**
     * @var object
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createQualifications()
    {
        for ($i = 0; $i < 10; $i++) {
            $academic_year = AcademicYear::factory()->create();
            $classroom_academic_year = ClassroomAcademicYear::factory()->create([
                'academic_year_id' => $academic_year->id
            ]);

            $academic_period_1 = AcademicPeriod::factory()->create([
                'academic_year_id' => $academic_year->id
            ]);

            $academic_period_2 = AcademicPeriod::factory()->create([
                'academic_year_id' => $academic_year->id
            ]);

            $academic_period_3 = AcademicPeriod::factory()->create([
                'academic_year_id' => $academic_year->id
            ]);

            $classroom_rubric_1 = ClassroomAcademicYearRubric::factory()->create([
                'classroom_academic_year_id' => $classroom_academic_year->id
            ]);

            $classroom_rubric_2 = ClassroomAcademicYearRubric::factory()->create([
                'classroom_academic_year_id' => $classroom_academic_year->id
            ]);

            $classroom_rubric_3 = ClassroomAcademicYearRubric::factory()->create([
                'classroom_academic_year_id' => $classroom_academic_year->id
            ]);

            $qualification = Qualification::factory()->create([
                'classroom_academic_year_id' => $classroom_academic_year->id,
                'classroom_academic_period_id' => $academic_period_1->id
            ]);

            QualificationItem::factory()->create([
                'qualification_id' => $qualification->id,
                'rubric_id' => $classroom_rubric_1->id,
                'percentage' => 34
            ]);
            QualificationItem::factory()->create([
                'qualification_id' => $qualification->id,
                'rubric_id' => $classroom_rubric_2->id,
                'percentage' => 33
            ]);
            QualificationItem::factory()->create([
                'qualification_id' => $qualification->id,
                'rubric_id' => $classroom_rubric_3->id,
                'percentage' => 33
            ]);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createQualifications();
    }
}
