<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjurySeverityLocation;
use Modules\Injury\Repositories\Interfaces\InjurySeverityLocationRepositoryInterface;

class InjurySeverityLocationRepository extends ModelRepository implements InjurySeverityLocationRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(InjurySeverityLocation $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}