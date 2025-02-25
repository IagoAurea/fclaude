<?php

namespace Modules\Health\Repositories;

use Modules\Health\Repositories\Interfaces\SurgeryRepositoryInterface;
use Modules\Health\Entities\Surgery;
use App\Services\ModelRepository;

class SurgeryRepository extends ModelRepository implements SurgeryRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * Instance a new repository
     */
    public function __construct(Surgery $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}