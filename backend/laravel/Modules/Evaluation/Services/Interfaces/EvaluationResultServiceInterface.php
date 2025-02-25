<?php

namespace Modules\Evaluation\Services\Interfaces;

interface EvaluationResultServiceInterface
{
    /**
     * Determinate the result of a rubric evaluation of a alumn
     * 
     * @param $rubric_id
     * @param $alumn_id
     * @param $classroom_academic_year_id
     * @return Number;
     */
    public function getResult($rubric_id, $alumn_id, $classroom_academic_year_id);

    /**
     * Get the evaluation result by competences of a alumn in a rubric
     * 
     * @param $rubric_id
     * @param $alumn_id
     * @return Number;
     */
    public function getResultByCompetences($rubric_id, $alumn_id, $classroom_academic_year_id, $percentage);

    /**
     * Get the evaluation result by competences of a alumn in a rubric
     * 
     * @param $rubric_id
     * @return Number;
     */
    public function initializeAlumnEvaluations($alumn_id, $classroom_academic_year_id);
}
