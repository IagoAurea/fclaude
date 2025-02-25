<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\ClassroomSubjectRepositoryInterface;
use Modules\Classroom\Entities\ClassroomSubject;
use App\Services\ModelRepository;

class ClassroomSubjectRepository extends ModelRepository implements ClassroomSubjectRepositoryInterface
{
    /**
     * Model
     * @var ClassroomSubject $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param ClassroomSubject $model
     */
    public function __construct(ClassroomSubject $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
