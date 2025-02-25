<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use App\Services\ModelRepository;

class ClassroomAcademicYearRepository extends ModelRepository implements ClassroomAcademicYearRepositoryInterface
{
    /**
     * Model
     * @var ClassroomAcademicYear $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param ClassroomAcademicYear $model
     */
    public function __construct(ClassroomAcademicYear $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function byClassroomIdAndYearIds($classroom_id, $yearIds = [])
    {
        $query = $this->model
            ->where('classroom_id', $classroom_id);

        if(count($yearIds) > 0) {
            $query->whereIn('academic_year_id', $yearIds);
        }
            
        return $query->get();
    }
}
