<?php

namespace Modules\Activity\Repositories;

use App\Services\ModelRepository;
use Modules\Activity\Entities\EntityActivity;
use Modules\Activity\Repositories\Interfaces\EntityActivityRepositoryInterface;

class EntityActivityRepository extends ModelRepository implements EntityActivityRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(EntityActivity $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
