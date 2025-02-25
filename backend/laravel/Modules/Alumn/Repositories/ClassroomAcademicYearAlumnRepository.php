<?php

namespace Modules\Alumn\Repositories;

use App\Services\ModelRepository;
use Modules\Alumn\Entities\ClassroomAcademicYearAlumn;
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;

class ClassroomAcademicYearAlumnRepository extends ModelRepository implements ClassroomAcademicYearAlumnRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ClassroomAcademicYearAlumn $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
