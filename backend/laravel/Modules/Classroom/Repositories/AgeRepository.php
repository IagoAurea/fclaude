<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\AgeRepositoryInterface;
use Modules\Classroom\Entities\Age;
use App\Services\ModelRepository;

class AgeRepository extends ModelRepository implements AgeRepositoryInterface
{
    /**
     * Model
     * @var Age $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Age $model
     */
    public function __construct(Age $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
