<?php

namespace Modules\Qualification\Services\Interfaces;

interface QualificationServiceInterface
{
    public function getListOfPeriodsByClassroomAcademicYear($id);
    public function getListOfAvailableRubricsByClassroomAcademicYear($id);
    public function addPercentageToRubric($id, $percentage);
    public function generateQualificationGrade($percentage, $evaluation_grade);
}
