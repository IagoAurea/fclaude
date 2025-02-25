<?php

namespace Modules\Activity\Repositories;

use App\Services\ModelRepository;
use Modules\Activity\Entities\ActivityType;
use Modules\Activity\Repositories\Interfaces\ActivityTypeRepositoryInterface;

class ActivityTypeRepository extends ModelRepository implements ActivityTypeRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(ActivityType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
