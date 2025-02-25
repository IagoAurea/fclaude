<?php

namespace Modules\Qualification\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\Qualification\Services\Interfaces\QualificationServiceInterface;
use Modules\Qualification\Services\Interfaces\QualificationResultServiceInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationItemRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationResultRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRubricRepositoryInterface;

class QualificationService implements QualificationServiceInterface
{
    /**
     * Repository
     * @var $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * Repository
     * @var $classroomAcademicYearRubricRepository
     */
    protected $classroomAcademicYearRubricRepository;

    /**
     * Repository
     * @var object $qualificationRepository
     */
    protected $qualificationRepository;

    /**
     * Repository
     * @var object $qualificationItemRepository
     */
    protected $qualificationItemRepository;

    /**
     * Repository
     * @var object $qualificationResultRepository
     */
    protected $qualificationResultRepository;

    /**
     * Repository
     * @var object $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    /**
     * Services
     *
     * @var $evaluationResultService
     */
    protected $evaluationResultService;
    
    /**
     * Services
     *
     * @var $qualificationResultService
     */
    protected $qualificationResultService;

    public function __construct(
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClassroomAcademicYearRubricRepositoryInterface $classroomAcademicYearRubricRepository,
        QualificationRepositoryInterface $qualificationRepository,
        QualificationItemRepositoryInterface $qualificationItemRepository,
        QualificationResultRepositoryInterface $qualificationResultRepository,
        EvaluationResultRepositoryInterface $evaluationResultRepository,
        EvaluationResultServiceInterface $evaluationResultService,
        QualificationResultServiceInterface $qualificationResultService
    ) {
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->classroomAcademicYearRubricRepository = $classroomAcademicYearRubricRepository;
        $this->qualificationRepository = $qualificationRepository;
        $this->qualificationItemRepository = $qualificationItemRepository;
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->qualificationResultRepository = $qualificationResultRepository;
        $this->evaluationResultService = $evaluationResultService;
        $this->qualificationResultService = $qualificationResultService;
    }

    /**
     * Store qualification
     * @params $request
     */
    public function store($request)
    {
        DB::beginTransaction();

        try {
            
            $qualification_payload = $request->only([
                'title',
                'description',
                'classroom_academic_year_id',
                'classroom_academic_period_id',
            ]);
    
            $qualification_payload['user_id'] = Auth::id();
    
            $qualification = $this->qualificationRepository->create($qualification_payload);
    
            if ($qualification) {
                $items = $request->only('items');
    
                foreach ($items['items'] as $item) {
                    $this->qualificationItemRepository->create([
                        'qualification_id' => $qualification->id,
                        'rubric_id' => $item['classroom_rubric_id'],
                        'percentage' => $item['percentage'],
                        'status' => true
                    ]);
                }
            }
            
            $newQualification = $this->qualificationRepository->findOneBy(['id' => $qualification->id]);
            
            $this->generateQualificationAlumnEvaluation($newQualification);

            DB::commit();

            return $newQualification;
            
        } catch (Exception $exception) {
            DB::rollBack();
            
            return $exception;
        }
    }

    public function getListOfQualifications($classroom_academic_year_id)
    {
        return $this->qualificationRepository->findBy(['classroom_academic_year_id' => $classroom_academic_year_id]);
    }

    public function getQualification($id)
    {
        return $this->qualificationRepository->findOneBy(['id' => $id]);
    }

     /**
     * Update qualification
     *
     * @param Request $request
     * @return Response
     */
    public function updateQualification($id, $request)
    {
        $qualification = $this->qualificationRepository->findOneBy(['id' => $id]);

        $qualification->update(
            $request->only(['title', 'description', 'status', 'classroom_academic_period_id', 'percentage'])
        );
        
        $this->qualificationItemRepository->bulkDelete(['qualification_id' => $qualification->id]);

        if ($request->has('items')) {
            $items = $request->only('items');

            foreach ($items['items'] as $item) {
                $this->qualificationItemRepository->create([
                    'qualification_id' => $qualification->id,
                    'rubric_id' => $item['classroom_rubric_id'],
                    'percentage' => $item['percentage'],
                    'status' => true
                ]);
            }
        }

        return $this->qualificationRepository->findOneBy(['id' => $id]);
    }

    public function deleteQualification($id)
    {
        return $this->qualificationRepository->delete($id);
    }

    public function getListOfPeriodsByClassroomAcademicYear($id)
    {
        $classroomAcademicYear = $this->classroomAcademicYearRepository->findOneBy(['id' => $id]);

        return $classroomAcademicYear->academicYear->academicPeriods;
    }

    public function getListOfAvailableRubricsByClassroomAcademicYear($id)
    {
        return $this->classroomAcademicYearRubricRepository->findBy(['classroom_academic_year_id' => $id]);
    }

    public function addPercentageToRubric($id, $percentage)
    {
        $classroomAcademicYearRubric = $this->classroomAcademicYearRubricRepository->findOneBy(['id' => $id]);

        return $classroomAcademicYearRubric->update(['qualification_percentage' => $percentage]);
    }

    public function generateQualificationGrade($percentage, $evaluation_grade)
    {
        return ($evaluation_grade * $percentage) / 100;
    }

    public function getPercentage($rubric_id)
    {
        return $this->qualificationItemRepository->findOneBy([
            'rubric_id' => $rubric_id,
        ]);
    }

    public function loadPdf($qualification_id, $alumn_id, $classroom_academic_year_id)
    {
        $qualification = $this->qualificationRepository->findOneBy(['classroom_academic_year_id' => $classroom_academic_year_id, 'id' => $qualification_id]);

        $result = [
            'qualification' => $qualification,
            'grade' => 0
        ];
        \Log::info($qualification);
        if ($qualification) {
            $items = $this->qualificationResultRepository->findBy([
                'qualification_id' => $qualification->id,
                'alumn_id' => $alumn_id
            ]);

            $qualification->qualificationItems->map(function ($item) use ($items, $alumn_id, $classroom_academic_year_id) {
                $item_id = $item->id;
                $item->evaluation = $this->evaluationResultRepository->findOneBy([
                    'classroom_academic_year_id' => $classroom_academic_year_id,
                    'evaluation_rubric_id' => $item->rubric_id,
                    'alumn_id' => $alumn_id
                ]);

                $itemFiltered = $items->firstWhere('qualification_item_id', $item_id);
                
                $competenceScore = isset($itemFiltered) ? json_decode($itemFiltered->competence_score) : null;

                $item->items = [
                    'result' => $itemFiltered->result ?? 0,
                    'competence_score' => $competenceScore
                ];
            });

            $result['grade'] = number_format($items->sum('result'), 2);

            $result['competences'] = $this->qualificationResultService->calculateAverageCompetencesScore($items);
        }
 
        return $result;
    }

    public function loadPdfAll($alumn_id, $classroom_academic_year_id)
    {
        $qualification = $this->qualificationRepository->findBy(['classroom_academic_year_id' => $classroom_academic_year_id]);

        $result = [
            'qualification' => $qualification,
            'grade' => 0
        ];

        if ($qualification) {
            $items = $this->qualificationResultRepository->findBy([ 'alumn_id' => $alumn_id]);
            
            $qualification->map(function ($item) use ($items, $alumn_id, $classroom_academic_year_id) {            
                $item->evaluation = $this->evaluationResultRepository->findOneBy([
                    'classroom_academic_year_id' => $classroom_academic_year_id,
                    'evaluation_rubric_id' => $item->qualificationItems[0]->rubric_id,
                    'alumn_id' => $alumn_id
                ]);
            });

            $result['competences'] = $this->qualificationResultService->calculateAverageCompetencesScore($items);
        }

        return $result;
    }
    /**
     * Generate qualification of alumns with evaluation
     */
    private function generateQualificationAlumnEvaluation($qualification)
    {
        $qualification->qualificationItems->each(function ($item) use($qualification) {
            $evaluationResults = $this->evaluationResultRepository->findBy([
                'classroom_academic_year_id' => $qualification->classroom_academic_year_id,
                'evaluation_rubric_id' => $item->rubric_id,
            ]);

            $evaluationResults->each(function ($result) use ($item, $qualification) {
                $qualificationGrade = $this->generateQualificationGrade(
                    $item->percentage,
                    $result->evaluation_grade
                );

                if ($qualificationGrade) {

                    $evaluation = $this->evaluationResultService->getResultByCompetences(
                        $item->rubric_id,
                        $result->alumn_id,
                        $qualification->classroom_academic_year_id,
                        $item->percentage
                    );

                    $this->qualificationResultRepository->create([
                        'qualification_item_id' => $item->id,
                        'alumn_id' => $result->alumn_id,
                        'result' => $qualificationGrade,
                        'qualification_id' => $item->qualification_id,
                        'competence_score' => json_encode($evaluation)
                    ]);
                }
            });
        });
    }
}
