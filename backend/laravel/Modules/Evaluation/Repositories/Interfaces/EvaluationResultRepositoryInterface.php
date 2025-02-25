<?php

namespace  Modules\Evaluation\Repositories\Interfaces;

interface EvaluationResultRepositoryInterface
{
    public function latestEvaluationsAlumns($classroom_academic_year_id);
}
