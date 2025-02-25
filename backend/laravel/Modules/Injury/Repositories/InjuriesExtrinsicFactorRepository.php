<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuriesExtrinsicFactor;
use Modules\Injury\Repositories\Interfaces\InjuriesExtrinsicFactorRepositoryInterface;

class InjuriesExtrinsicFactorRepository extends ModelRepository implements InjuriesExtrinsicFactorRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(InjuriesExtrinsicFactor $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}