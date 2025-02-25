<?php

namespace Modules\Alumn\Observers;

use Modules\Alumn\Entities\ClassroomAcademicYearAlumn;
use Modules\AlumnControl\Services\DailyControlItemService;
use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class ClassroomAcademicYearAlumnObserver
{
    /**
     * @var object $controlItemService
     */
    protected $controlItemService;
    
    /**
     * @var object $evaluationResultService
     */
    protected $evaluationResultService;

    /**
     * @var object $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * Creates a new observer instance
     */
    public function __construct(
        DailyControlItemService $controlItemService,
        EvaluationResultServiceInterface $evaluationResultService,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    ) {
        $this->controlItemService = $controlItemService;
        $this->evaluationResultService = $evaluationResultService;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  ClassroomAcademicYearAlumn  $classroomAcademicYearAlumn
     * @return void
     */
    public function created(ClassroomAcademicYearAlumn $classroomAcademicYearAlumn)
    {
        $alumnId = $classroomAcademicYearAlumn->alumn_id;
        
        $classroomAcademicYearId = $classroomAcademicYearAlumn->classroom_academic_year_id;

        $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
            'id' => $classroomAcademicYearId
        ]);

        $academicPeriodId = $classroomYear->academicYear->active_academic_period->id ?? null;

        $this->controlItemService->registerAlumnSet($alumnId, $classroomAcademicYearId, $academicPeriodId);

        $this->evaluationResultService->initializeAlumnEvaluations(
            $classroomAcademicYearAlumn->alumn_id,
            $classroomAcademicYearAlumn->classroom_academic_year_id
        );
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  ClassroomAcademicYearAlumn  $classroomAcademicYearAlumn
     * @return void
     */
    public function updated(ClassroomAcademicYearAlumn $classroomAcademicYearAlumn)
    {
        //
    }

    /**
     * Handle the alumn "deleted" event.
     *
     * @param  ClassroomAcademicYearAlumn  $classroomAcademicYearAlumn
     * @return void
     */
    public function deleted(ClassroomAcademicYearAlumn $classroomAcademicYearAlumn)
    {
        //
    }

    /**
     * Handle the alumn "forceDeleted" event.
     *
     * @param  ClassroomAcademicYearAlumn  $classroomAcademicYearAlumn
     * @return void
     */
    public function forceDeleted(ClassroomAcademicYearAlumn $classroomAcademicYearAlumn)
    {
        //
    }
}
