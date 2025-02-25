<?php

namespace  Modules\Classroom\Repositories\Interfaces;

interface ClassroomAcademicYearRepositoryInterface
{
    public function byClassroomIdAndYearIds($classroom_id, $yearIds = []);
}
