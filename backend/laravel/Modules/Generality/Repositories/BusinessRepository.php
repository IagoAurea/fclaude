<?php

namespace Modules\Generality\Repositories;

use App\Services\ModelRepository;
use Modules\Generality\Entities\Business;
use Modules\Generality\Repositories\Interfaces\BusinessRepositoryInterface;

class BusinessRepository extends ModelRepository implements BusinessRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Business $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}