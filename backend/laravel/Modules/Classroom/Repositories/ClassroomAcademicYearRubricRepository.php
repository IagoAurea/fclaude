<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRubricRepositoryInterface;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use App\Services\ModelRepository;

class ClassroomAcademicYearRubricRepository extends ModelRepository implements ClassroomAcademicYearRubricRepositoryInterface
{
    /**
     * Model
     * @var ClassroomAcademicYearRubric $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param ClassroomAcademicYearRubric $model
     */
    public function __construct(ClassroomAcademicYearRubric $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
