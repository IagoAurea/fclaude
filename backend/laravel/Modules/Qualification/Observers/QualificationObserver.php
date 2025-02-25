<?php

namespace Modules\Qualification\Observers;

use Modules\Qualification\Entities\Qualification;
use Modules\Qualification\Repositories\Interfaces\QualificationResultRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Qualification\Services\Interfaces\QualificationServiceInterface;

class QualificationObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;
    
    /**
     * @var object $qualificationService
     */
    protected $qualificationService;
    
    /**
     * @var object $qualificationResultRepository
     */
    protected $qualificationResultRepository;
    
    /**
     * @var object $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    /**
     * Creates a new observer instance
     */
    public function __construct(
        QualificationServiceInterface $qualificationService,
        QualificationResultRepositoryInterface $qualificationResultRepository,
        EvaluationResultRepositoryInterface $evaluationResultRepository
    ) {
        $this->qualificationService = $qualificationService;
        $this->qualificationResultRepository = $qualificationResultRepository;
        $this->evaluationResultRepository = $evaluationResultRepository;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  Qualification  $qualification
     * @return void
     */
    public function created(Qualification $qualification)
    {
        // $qualification->qualificationItems->each(function ($item) {
        //     $evaluationResults = $this->evaluationResultRepository->findBy([
        //         'classroom_academic_year_id' => $item->classroomRubric->classroom_academic_year_id,
        //         'evaluation_rubric_id' => $item->classroomRubric->rubric_id,
        //     ]);

        //     $evaluationResults->each(function ($result) use ($item) {
        //         $qualificationGrade = $this->qualificationService->generateQualificationGrade(
        //             $item->percentage,
        //             $result->evaluation_grade
        //         );

        //         if ($qualificationGrade) {
        //             $this->qualificationResultRepository->create([
        //                 'qualification_item_id' => $item->id,
        //                 'alumn_id' => $result->alumn_id,
        //                 'result' => $qualificationGrade,
        //             ]);
        //         }
        //     });
        // });
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  Qualification $qualification
     * @return void
     */
    public function updated(Qualification $qualification)
    {
    }

    /**
     * Handle the alumn "deleted" event.
     *
     * @param  Qualification $qualification
     * @return void
     */
    public function deleted(Qualification $qualification)
    {
        //
    }

    /**
     * Handle the alumn "forceDeleted" event.
     *
     * @param  Qualification $qualification
     * @return void
     */
    public function forceDeleted(Qualification $qualification)
    {
        //
    }
}
