<?php

namespace Modules\Evaluation\Repositories;

use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Evaluation\Entities\EvaluationResult;
use App\Services\ModelRepository;

class EvaluationResultRepository extends ModelRepository implements EvaluationResultRepositoryInterface
{
    /**
     * Model
     * @var EvaluationResult $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param EvaluationResult $model
     */
    public function __construct(EvaluationResult $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Find rubrics by user id
     * 
     * @param int $user_id
     */
    public function findByUser($user_id)
    {
        $evaluations = $this->findBy(['user_id', $user_id]);

        if (!$evaluations) {
            throw new ModelNotFoundException;
        }

        return $evaluations;
    }

    /**
     * Find rubrics by player id
     * 
     * @param int $player_id
     */
    public function findByPlayer($player_id)
    {
        $evaluations = $this->findBy(['player_id', $player_id]);

        if (!$evaluations) {
            throw new ModelNotFoundException;
        }

        return $evaluations;
    }

    /**
     * Find rubrics by alumn id
     * 
     * @param int $alumn_id
     */
    public function findByAlumn($rubric_ids, $alumn_id, $classroom_academic_year_id)
    {
        $evaluations = $this->model
            ->whereIn('evaluation_rubric_id', $rubric_ids)
            ->where([
                'alumn_id' => $alumn_id,
                'classroom_academic_year_id' => $classroom_academic_year_id
            ])
            ->get();

        if (!$evaluations) {
            throw new ModelNotFoundException;
        }

        return $evaluations;
    }

    /**
     * Find last evaluation by alumn
     * 
     * @param int $classroom_academic_year_id
     */
    public function latestEvaluationsAlumns($classroom_academic_year_id)
    {
        return $this->model
            ->where([
                'classroom_academic_year_id' => $classroom_academic_year_id,
                'status' => EvaluationResult::STATUS_EVALUATED
            ])
            ->limit(10)
            ->latest()
            ->get([
                'id', 'alumn_id', 'classroom_academic_year_id', 'evaluation_rubric_id', 'evaluation_grade', 'created_at'
            ]);
    }

    /**
     * Find last evaluation by alumn
     * 
     * @param int $alumn_id
     * @param int $classroom_academic_year_id
     */
    public function latestEvaluationByAlumn($alumn_id, $classroom_academic_year_id)
    {
        $evaluations = $this->model
            ->where([
                'alumn_id' => $alumn_id,
                'classroom_academic_year_id' => $classroom_academic_year_id,
                'status' => EvaluationResult::STATUS_EVALUATED
            ])
            ->latest()
            ->first();

        return $evaluations;
    }

    /**
     * Find rubrics by alumn id
     * 
     * @param int $alumn_id
     * @param int $classroom_academic_year_id
     */
    public function evaluationsByAlumn($alumn_id, $classroom_academic_year_id)
    {
        $evaluations = $this->model
            ->where([
                'alumn_id' => $alumn_id,
                'classroom_academic_year_id' => $classroom_academic_year_id,
                'status' => EvaluationResult::STATUS_EVALUATED
            ])
            ->get();

        return $evaluations;
    }

    /**
     * Find if rubric has been evaluaated
     * 
     * @param int $rubric_id
     * @param int $classroom_academic_year_id
     */
    public function rubricEvaluated($rubric_id, $classroom_academic_year_id)
    {
        $evaluations = $this->model
            ->where([
                'evaluation_rubric_id' =>  $rubric_id,
                'classroom_academic_year_id' => $classroom_academic_year_id,
                'status' => EvaluationResult::STATUS_EVALUATED
            ])
            ->get();

        return $evaluations->count() > 0;
    }
}
