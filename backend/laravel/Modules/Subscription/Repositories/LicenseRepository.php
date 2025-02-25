<?php

namespace Modules\Subscription\Repositories;

use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;
use Modules\Subscription\Entities\License;
use App\Services\ModelRepository;

class LicenseRepository extends ModelRepository implements LicenseRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(License $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}