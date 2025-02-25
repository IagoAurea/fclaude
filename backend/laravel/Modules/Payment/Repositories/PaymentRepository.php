<?php

namespace Modules\Payment\Repositories;

use Modules\Payment\Repositories\Interfaces\PaymentRepositoryInterface;
use Modules\Payment\Entities\Payment;
use App\Services\ModelRepository;

class PaymentRepository extends ModelRepository implements PaymentRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}