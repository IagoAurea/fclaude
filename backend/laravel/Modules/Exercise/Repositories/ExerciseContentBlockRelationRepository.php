<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRelationRepositoryInterface;
use Modules\Exercise\Entities\ExerciseContentBlockRelation;
use App\Services\ModelRepository;

class ExerciseContentBlockRelationRepository extends ModelRepository implements ExerciseContentBlockRelationRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseContentBlockRelation $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
