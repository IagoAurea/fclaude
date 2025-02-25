<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuriesIntrinsicFactor;
use Modules\Injury\Repositories\Interfaces\InjuriesIntrinsicFactorRepositoryInterface;

class InjuriesIntrinsicFactorRepository extends ModelRepository implements InjuriesIntrinsicFactorRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(InjuriesIntrinsicFactor $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}