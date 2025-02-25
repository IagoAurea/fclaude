<?php

namespace Modules\Evaluation\Tests\Unit;

use Modules\Evaluation\Tests\Fixtures\ClassroomAcademicYearAlumnObserverFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Alumn\Entities\ClassroomAcademicYearAlumn;
use Tests\ModuleTestCase;

class ClassroomAcademicYearAlumnObserverTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use ClassroomAcademicYearAlumnObserverFixturesTrait;

    /**
     * @test
     * Test the observer its initializing the evaluation results
     *
     * @return void
     */
    public function test_observer_initialize_evaluation_results()
    {
        $this->preparePayload();

        $result = $this->evaluationResultRepository->findOneBy(['classroom_academic_year_id' => $this->payload['classroom_academic_year_id']]);
        $this->assertFalse(isset($result));

        $classroom_academic_year_alumn = ClassroomAcademicYearAlumn::create($this->payload);
        $result = $this->evaluationResultRepository->findOneBy(['classroom_academic_year_id' => $this->payload['classroom_academic_year_id']]);
        $this->assertTrue(isset($result));
    }
}
