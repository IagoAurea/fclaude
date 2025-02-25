<?php

namespace Modules\Payment\Repositories;

use App\Services\ModelRepository;
use Modules\Payment\Repositories\Interfaces\TaxRepositoryInterface;
use Modules\Payment\Entities\Tax;

class TaxRepository extends ModelRepository implements TaxRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Tax $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}