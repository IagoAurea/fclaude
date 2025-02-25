<?php

namespace  Modules\Evaluation\Repositories\Interfaces;

interface RubricRepositoryInterface
{
    /**
     * Find rubrics by classroom id
     * 
     * @param int $classroom_id
     */
    public function findByClassroom($classroom_id);

    /**
     * Assign indicators to the rubric
     * 
     * @param Boolean
     */
    public function assignIndicatorsToRubric($rubric_id, $indicators);

    /**
     * Assign classrooms to the rubric
     * 
     * @param Boolean
     */
    public function assignClassroomsToRubric($rubric_id, $classrooms);

    /**
     * Get the comoetences associated to a given rubric with their indicator
     * 
     * @param int $rubric_id
     */
    public function getCompetences($rubric_id);

    /**
     * Get indicators with percentage of a given rubric
     * 
     * @param mixed
     */
    public function getIndicators($rubric_id);

    /**
     * Get rubric collection by a given id
     * 
     * @param int $rubric_id
     */
    public function getExportDataById($rubric_id);
}
