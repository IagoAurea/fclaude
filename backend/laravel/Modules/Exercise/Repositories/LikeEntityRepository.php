<?php

namespace Modules\Exercise\Repositories;

use App\Services\ModelRepository;
use Modules\Exercise\Entities\LikeEntity;
use Modules\Exercise\Repositories\Interfaces\LikeEntityRepositoryInterface;

class LikeEntityRepository extends ModelRepository implements LikeEntityRepositoryInterface
{
	/**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(LikeEntity $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
