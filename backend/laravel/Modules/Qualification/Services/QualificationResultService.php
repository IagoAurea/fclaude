<?php

namespace Modules\Qualification\Services;

use Modules\Qualification\Services\Interfaces\QualificationResultServiceInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationItemRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationResultRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRubricRepositoryInterface;

class QualificationResultService implements QualificationResultServiceInterface
{
    /**
     * Repository
     * @var $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;
    
    /**
     * Repository
     * @var $classroomAcademicYearAlumnRepository
     */
    protected $classroomAcademicYearAlumnRepository;

    /**
     * Repository
     * @var $qualificationResultRepository
     */
    protected $qualificationResultRepository;

    /**
     * Repository
     * @var $classroomAcademicYearRubricRepository
     */
    protected $classroomAcademicYearRubricRepository;

    /**
     * Repository
     * @var $qualificationRepository
     */
    protected $qualificationRepository;

    /**
     * Repository
     * @var $qualificationItemRepository
     */
    protected $qualificationItemRepository;

    /**
     * Repository
     * @var object $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    public function __construct(
        ClassroomAcademicYearAlumnRepositoryInterface $classroomAcademicYearAlumnRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClassroomAcademicYearRubricRepositoryInterface $classroomAcademicYearRubricRepository,
        QualificationRepositoryInterface $qualificationRepository,
        QualificationResultRepositoryInterface $qualificationResultRepository,
        QualificationItemRepositoryInterface $qualificationItemRepository,
        EvaluationResultRepositoryInterface $evaluationResultRepository
    ) {
        $this->classroomAcademicYearAlumnRepository = $classroomAcademicYearAlumnRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->classroomAcademicYearRubricRepository = $classroomAcademicYearRubricRepository;
        $this->qualificationRepository = $qualificationRepository;
        $this->qualificationResultRepository = $qualificationResultRepository;
        $this->qualificationItemRepository = $qualificationItemRepository;
        $this->evaluationResultRepository = $evaluationResultRepository;
    }

    public function classroom($classroom_academic_year_id)
    {
        $results = [];

        $qualifications = $this
            ->qualificationRepository
            ->findBy(['classroom_academic_year_id' => $classroom_academic_year_id]);

        $alumns = $this->classroomAcademicYearAlumnRepository
            ->findBy(['classroom_academic_year_id' => $classroom_academic_year_id]);

        $qualification_ids = $qualifications->pluck('id');

        $qualification_item_results = $this->qualificationResultRepository
            ->findIn('qualification_id', $qualification_ids->toArray());

        $results = $alumns->map(function ($alumn) use ($qualification_item_results, $qualifications) {
            return [
                'alumn' => $alumn->alumn->only(['id', 'full_name', 'image_id', 'image', 'gender_id', 'gender']),
                'qualifications' =>
                $qualifications->map(function ($qualification) use ($qualification_item_results, $alumn) {
                    $items = $qualification_item_results
                        ->where('qualification_id', $qualification->id)->where('alumn_id', $alumn->alumn_id);
                    return [
                        'qualification' => $qualification->only([
                            'id', 'title', 'description','classroom_academic_year_id', 'classroom_academic_period_id'
                        ]),
                        'grade' => number_format($items->sum('result'), 2)
                    ];
                })
            ];
        });

        return $results->toArray();
    }

    public function qualificationAlumnByClassroom($qualification_id, $alumn_id, $classroom_academic_year_id)
    {
        $results = [];

        $qualification = $this
            ->qualificationRepository
            ->findOneBy([
                'id' => $qualification_id,
                'classroom_academic_year_id' => $classroom_academic_year_id
            ]);
        
        $qualification->makeHidden(['classroom_academic_year']);
        $qualification->tutor;

        $results = [
            'qualification' => $qualification,
            'grade' => 0,
        ];
        
        if ($qualification) {
            $items = $this->qualificationResultRepository->findBy([
                'qualification_id' => $qualification->id,
                'alumn_id' => $alumn_id
            ]);

            $qualification->qualificationItems->map(function($item) use($items, $alumn_id, $classroom_academic_year_id){
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

            $results['grade'] = number_format($items->sum('result'), 2);

            $results['competences'] = $this->calculateAverageCompetencesScore($items);
        }

        return $results;
    }

    /**
     * Calculate average competence score
     * @param $items
     */
    public function calculateAverageCompetencesScore($items)
    {
        $competence_results = [];

        foreach ($items as $item) {
            $competences_score = json_decode($item->competence_score);

            foreach ($competences_score as $score) {
                $keyScore = array_search($score->competence_id, array_column($competence_results, 'competence_id'));
                
                $itemScore = new \stdClass;
                $itemScore->competence = $score->competence;
                $itemScore->competence_id = $score->competence_id;
                $itemScore->competence_key = $score->competence_key;

                if (gettype($keyScore) == 'boolean' ) {
                    $itemScore->grade_total = $score->grade;
                    $itemScore->total = 1;
                    $itemScore->average = number_format($itemScore->grade_total, 2);
                    array_push($competence_results, $itemScore);
                } else {
                    $competence_results[$keyScore]->total += 1;
                    $competence_results[$keyScore]->grade_total += $score->grade;
                    $competence_results[$keyScore]->average =  $competence_results[$keyScore]->grade_total > 0 ?
                        number_format($competence_results[$keyScore]->grade_total / $competence_results[$keyScore]->total, 2) :
                        0;
                }

            }

        }

        return $competence_results;
    }
}
