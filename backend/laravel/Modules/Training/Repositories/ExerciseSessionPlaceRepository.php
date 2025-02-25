<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\ExerciseSessionPlace;
use Modules\Training\Repositories\Interfaces\ExerciseSessionPlaceRepositoryInterface;

class ExerciseSessionPlaceRepository extends ModelRepository implements ExerciseSessionPlaceRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(ExerciseSessionPlace $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}