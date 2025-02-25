<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Classroom\Entities\Teacher;
use App\Services\ModelRepository;

class TeacherRepository extends ModelRepository implements TeacherRepositoryInterface
{
    /**
     * Model
     * @var Teacher $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Teacher $model
     */
    public function __construct(Teacher $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
