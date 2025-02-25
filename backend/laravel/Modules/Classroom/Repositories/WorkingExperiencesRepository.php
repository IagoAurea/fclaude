<?php

namespace  Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;
use Modules\Classroom\Entities\WorkingExperiences;
use App\Services\ModelRepository;

class WorkingExperiencesRepository extends ModelRepository implements WorkingExperiencesRepositoryInterface
{
    /**
     * Model
     * @var WorkingExperiences $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param WorkingExperiences $model
     */
    public function __construct(WorkingExperiences $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
