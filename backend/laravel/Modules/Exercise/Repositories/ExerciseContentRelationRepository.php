<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\ExerciseContentRelationRepositoryInterface;
use Modules\Exercise\Entities\ExerciseContentRelation;
use App\Services\ModelRepository;

class ExerciseContentRelationRepository extends ModelRepository implements ExerciseContentRelationRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseContentRelation $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
