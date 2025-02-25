<?php

namespace Modules\Subscription\Repositories;

use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;
use Modules\Subscription\Entities\Subscription;
use App\Services\ModelRepository;

class SubscriptionRepository extends ModelRepository implements SubscriptionRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Subscription $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}