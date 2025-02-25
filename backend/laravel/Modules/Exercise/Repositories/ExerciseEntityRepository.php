<?php

namespace Modules\Exercise\Repositories;

use App\Services\ModelRepository;
use Modules\Exercise\Entities\ExerciseEntity;
use Modules\Exercise\Repositories\Interfaces\ExerciseEntityRepositoryInterface;

class ExerciseEntityRepository extends ModelRepository implements ExerciseEntityRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseEntity $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
