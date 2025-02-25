<?php

namespace Modules\Evaluation\Repositories;

use Modules\Evaluation\Repositories\Interfaces\EvaluationGradeRepositoryInterface;
use Modules\Evaluation\Entities\EvaluationGrade;
use App\Services\ModelRepository;

class EvaluationGradeRepository extends ModelRepository implements EvaluationGradeRepositoryInterface
{
    /**
     * Model
     * @var EvaluationGrade $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param EvaluationGrade $model
     */
    public function __construct(EvaluationGrade $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve evaluations grade by alumn and academic year
     */
    public function evaluationByAlumnClassroomAcademic($alumnId, $academicYearId)
    {
        return $this->model
            ->where('alumn_id', $alumnId)
            ->where('classroom_academic_year_id', $academicYearId)
            ->groupBy(['id', 'alumn_id', 'classroom_academic_year_id'])
            ->get();
    }

    /**
     * Gets the alumn grades by indicators
     * 
     * @param $alumn_id
     * @param $indicators
     */
    public function getAlumnGradesByIndicators($alumn_id, $classroom_academic_year_id, $indicators)
    {
        return $this->model
            ->where('alumn_id', $alumn_id)
            ->where('classroom_academic_year_id', $classroom_academic_year_id)
            ->whereIn('indicator_rubric_id', $indicators)
            ->get();
    }
}
