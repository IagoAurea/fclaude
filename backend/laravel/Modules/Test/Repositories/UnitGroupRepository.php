<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\Unit;
use Modules\Test\Entities\UnitGroup;
use Modules\Test\Repositories\Interfaces\UnitGroupRepositoryInterface;

class UnitGroupRepository extends ModelRepository implements UnitGroupRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(UnitGroup $model)
    {
        $this->model = $model;

        parent::__construct($this->model, ['unit']);
    }
}
