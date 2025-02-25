<?php

namespace Modules\Evaluation\Tests\Fixtures;

use Modules\Classroom\Entities\ClassroomAcademicYear;
use Modules\Alumn\Entities\Alumn;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use Modules\Evaluation\Entities\Rubric;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;

trait ClassroomAcademicYearAlumnObserverFixturesTrait
{
    /**
     * * The payload property will be used
     * * to store the testing data for
     * * every test case running
     *
     * @var mixed
     */
    private $payload = [];
    private $evaluationResultRepository;

    /**
     * * Prepare the payload to be a classroom
     * * academic year alumn record
     *
     * @param string $status
     * @return void
     */
    private function preparePayload()
    {
        $this->evaluationResultRepository = app()->make(EvaluationResultRepositoryInterface::class);
        $classroom_academic_year = ClassroomAcademicYear::factory()->create();
        $rubric = Rubric::factory()->create();
        $alumn = Alumn::latest()->first();

        $classroom_academic_year_rubric = ClassroomAcademicYearRubric::create([
            'classroom_academic_year_id' => $classroom_academic_year->id,
            'rubric_id' => $rubric->id
        ]);

        $this->payload = [
            'classroom_academic_year_id' => $classroom_academic_year->id,
            'alumn_id' => $alumn->id,
        ];
    }
}
