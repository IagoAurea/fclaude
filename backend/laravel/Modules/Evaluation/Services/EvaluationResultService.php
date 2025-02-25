<?php

namespace Modules\Evaluation\Services;

use Exception;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRubricRepositoryInterface;
use Modules\Evaluation\Entities\EvaluationResult;
use Modules\Evaluation\Repositories\Interfaces\EvaluationGradeRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\CompetenceRepositoryInterface;
use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Exceptions\AlumnHasNoGradesRegisteredException;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use App\Traits\TranslationTrait;

class EvaluationResultService implements EvaluationResultServiceInterface
{
    use TranslationTrait;

    const EX = 9;
    const MA = 7;
    const AD = 5;
    const PA = 1;

    const EX_VALUE = 4;
    const MA_VALUE = 3;
    const AD_VALUE = 2;
    const PA_VALUE = 1;
    const UR_VALUE = 0;
    
    const EX_MIN_VALUE = 3.5;
    const MA_MIN_VALUE = 2.5;
    const AD_MIN_VALUE = 1.5;
    const PA_MIN_VALUE = 0;

    const COMPETENCES_KEY = [
        self::EX_VALUE => 'excellent',
        self::MA_VALUE => 'very_suitable',
        self::AD_VALUE => 'appropriate',
        self::PA_VALUE => 'unsuitable',
        self::UR_VALUE => 'unrated'
    ];

    /**
     * Repository
     * @var $rubricRepository
     */
    protected $rubricRepository;

    /**
     * Repository
     * @var $competenceRepository
     */
    protected $competenceRepository;

    /**
     * Repository
     * @var $evaluationGradeRepository
     */
    protected $evaluationGradeRepository;

    /**
     * Repository
     * @var $classroomAcademicYearRubricRepository
     */
    protected $classroomAcademicYearRubricRepository;

    /**
     * Repository
     * @var $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    /**
     * Accumulator
     * @var $competenceAccumulator
     */
    protected $competenceAccumulator;

    /**
     * Counter
     * @var $competenceCounter
     */
    protected $competenceCounter;

    public function __construct(
        RubricRepositoryInterface $rubricRepository,
        CompetenceRepositoryInterface $competenceRepository,
        EvaluationGradeRepositoryInterface $evaluationGradeRepository,
        ClassroomAcademicYearRubricRepositoryInterface $classroomAcademicYearRubricRepository,
        EvaluationResultRepositoryInterface $evaluationResultRepository
    ) {
        $this->evaluationGradeRepository = $evaluationGradeRepository;
        $this->rubricRepository = $rubricRepository;
        $this->competenceRepository = $competenceRepository;
        $this->classroomAcademicYearRubricRepository = $classroomAcademicYearRubricRepository;
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->competenceAccumulator = [];
        $this->competenceCounter = [];
    }

    /**
     * Determinate the result of a rubric evaluation of a alumn
     * 
     * @param $rubric_id
     * @param $alumn_id
     * @param $classroom_academic_year_id
     * @return Number;
     */
    public function getResult($rubric_id, $alumn_id, $classroom_academic_year_id)
    {
        try {
            $evaluation_result = $this->evaluationResultRepository->findOneBy([
                'evaluation_rubric_id' => $rubric_id,
                'alumn_id' => $alumn_id,
                'classroom_academic_year_id' => $classroom_academic_year_id
            ]);

            $competences = $this->rubricRepository->getCompetences($rubric_id);
            $indicators = $this->rubricRepository->getIndicators($rubric_id);
            $grades = $this->evaluationGradeRepository->getAlumnGradesByIndicators($alumn_id, $classroom_academic_year_id, $indicators);

            // if ($grades->count() == 0) {
            //     throw new AlumnHasNoGradesRegisteredException;
            // }

            if ($evaluation_result && $evaluation_result->status === EvaluationResult::STATUS_EVALUATED) {
                $score = $evaluation_result->evaluation_grade;
                $status = $evaluation_result->status;
            } else {
                $score = $this->calculateRealGradesValue($grades);
                $status = EvaluationResult::STATUS_NOT_EVALUATED;
            }

            return [
                'score' => number_format($score, 2),
                'competences_score' => $this->calculateGradesByCompetences($grades, $competences),
                'status' => $status,
                'grades' => $grades
            ];
        } catch (RubricDoesNotExistException $exception) {
            throw $exception;
        }
    }

    /**
     * Get the evaluation result by competences of a alumn in a rubric
     *
     * @param $rubric_id
     * @param $alumn_id
     * @return Number;
     */
    public function getResultByCompetences($rubric_id, $alumn_id, $classroom_academic_year_id, $percentage = 100)
    {
        try {
            $indicators = $this->rubricRepository->getIndicators($rubric_id);

            $competences = $this->rubricRepository->getCompetences($rubric_id);
            
            $grades = $this->evaluationGradeRepository->getAlumnGradesByIndicators(
                $alumn_id, $classroom_academic_year_id, $indicators
            );

            return $this->calculateGradesByCompetences($grades, $competences, $percentage);
        } catch (RubricDoesNotExistException $exception) {
            throw $exception;
        }
    }

    /**
     * Calculate the real value using the percentage of the indicator
     *
     * @param $grades
     * @return Number;
     */
    private function calculateRealGradesValue($grades)
    {
        return $grades->sum(function ($grade) {
            return ($grade->grade * $grade->indicatorRubric->indicator->percentage) / 100;
        });
    }

    /**
     * Calculate the real value using the percentage of the indicator
     *
     * @param $grades
     * @return Number;
     */
    private function calculateGradesByCompetences($grades, $competences, $percentage = 100)
    {
        $gradesByCompetences = $competences->map(function ($indicator) use ($grades) {
            $result = $grades->firstWhere('indicator_rubric_id', $indicator['indicator_id']);
            $grade = 0;

            if ($result) {
                $grade = $this->getCompetenceValue($result->grade);
            }
            return [
                'grade' => $grade,
                'competences' => $indicator['competences']
            ];
        });

        $this->competenceAccumulator = [];
        $this->competenceCounter = [];
        
        $gradesByCompetences->each(function ($item) {
            foreach ($item['competences'] as $competence) {
                if (!isset($this->competenceAccumulator[$competence])) {
                    $this->competenceAccumulator[$competence] = 0;
                }
                if (!isset($this->competenceCounter[$competence])) {
                    $this->competenceCounter[$competence] = 0;
                }
                $this->competenceAccumulator[$competence] += floatval($item['grade']);
                $this->competenceCounter[$competence]++;
            }
        });

        $result = [];
        foreach ($this->competenceAccumulator as $competence_id => $grade) {
            $average = $grade / $this->competenceCounter[$competence_id];

            $result[] = [
                'competence_id' => $competence_id,
                'competence' => $this->competenceRepository->find($competence_id),
                'grade' => $average,
                'competence_key' => $this->translator($this->getCompetenceAverageValue($average))
            ];
        }

        return $result;
    }

    /**
     * Calculate the value of a competence
     *
     * @param $grades
     * @return Number;
     */
    private function getCompetenceAverageValue($average)
    {
        if ($average >= self::EX_MIN_VALUE) {
            return self::COMPETENCES_KEY[self::EX_VALUE];
        }
        if ($average >= self::MA_MIN_VALUE) {
            return self::COMPETENCES_KEY[self::MA_VALUE];
        }
        if ($average >= self::AD_MIN_VALUE) {
            return self::COMPETENCES_KEY[self::AD_VALUE];
        }
        if ($average >= self::PA_MIN_VALUE) {
            return self::COMPETENCES_KEY[self::PA_VALUE];
        }
    }

    /**
     * Calculate the value of a competence
     *
     * @param $grades
     * @return Number;
     */
    private function getCompetenceValue($grade)
    {
        if ($grade >= self::EX) {
            return self::EX_VALUE;
        }
        if ($grade >= self::MA) {
            return self::MA_VALUE;
        }
        if ($grade >= self::AD) {
            return self::AD_VALUE;
        }
        if ($grade >= self::PA) {
            return self::PA_VALUE;
        }

        return 1;
    }

    /**
     * Initialize the evaluations of the alumns to be 0, this runs after a
     * alumn is assigned to a classroom through an Observer called
     * ClassroomAcademicYearAlumnObserver
     * 
     * @param $alumn_id
     * @param $classroom_academic_year_id
     * @return bool;
     */
    public function initializeAlumnEvaluations($alumn_id, $classroom_academic_year_id)
    {
        try {
            $rubric_ids = $this
                ->classroomAcademicYearRubricRepository
                ->findBy(['classroom_academic_year_id' => $classroom_academic_year_id])
                ->map->rubric
                ->map->id;

            $rubric_ids->each(function ($rubric_id) use ($alumn_id, $classroom_academic_year_id) {
                $payload = [
                    'alumn_id' => $alumn_id,
                    'classroom_academic_year_id' => $classroom_academic_year_id,
                    'evaluation_rubric_id' => $rubric_id,
                    'evaluation_grade' => 0,
                    'status' => EvaluationResult::STATUS_NOT_EVALUATED,
                ];

                $result = $this->evaluationResultRepository->create($payload);
            });

            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
