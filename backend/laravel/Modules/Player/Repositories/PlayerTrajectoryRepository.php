<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\PlayerTrajectory;
use Modules\Player\Repositories\Interfaces\PlayerTrajectoryRepositoryInterface;
use App\Traits\TranslationTrait;

class PlayerTrajectoryRepository extends ModelRepository implements PlayerTrajectoryRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(PlayerTrajectory $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}