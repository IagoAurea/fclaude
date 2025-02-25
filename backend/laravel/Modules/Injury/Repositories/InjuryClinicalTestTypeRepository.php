<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryClinicalTestType;
use Modules\Injury\Repositories\Interfaces\InjuryClinicalTestTypeRepositoryInterface;

class InjuryClinicalTestTypeRepository extends ModelRepository implements InjuryClinicalTestTypeRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(InjuryClinicalTestType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}