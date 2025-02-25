<?php

namespace Modules\AlumnControl\Repositories\Interfaces;

interface DailyControlRepositoryInterface
{
    public function findAlumnItems($alumnId, $classroomAcademicYearId, $academicPeriodId, $date);

    public function reset($classroomAcademicYearId, $academicPeriodId, $alumnId);
}
