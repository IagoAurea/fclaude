<?php

namespace Modules\Exercise\Repositories;

use App\Services\ModelRepository;
use Modules\Exercise\Entities\ExerciseTargetSession;
use Modules\Exercise\Repositories\Interfaces\ExerciseTargetSessionRepositoryInterface;

class ExerciseTargetSessionRepository extends ModelRepository implements ExerciseTargetSessionRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseTargetSession $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
