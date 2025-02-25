<?php

namespace  Modules\Evaluation\Repositories\Interfaces;

interface EvaluationGradeRepositoryInterface
{
    /**
     * Gets the alumn grades by indicators
     * 
     * @param $alumn_id
     * @param $classroom_academic_year_id
     * @param $indicators
     */
    public function getAlumnGradesByIndicators($alumn_id, $classroom_academic_year_id, $indicators);

    public function evaluationByAlumnClassroomAcademic($alumnId, $academicYearId);
}
