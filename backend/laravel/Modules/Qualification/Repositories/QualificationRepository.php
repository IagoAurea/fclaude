<?php

namespace Modules\Qualification\Repositories;

use Modules\Qualification\Repositories\Interfaces\QualificationRepositoryInterface;
use Modules\Qualification\Entities\Qualification;
use App\Services\ModelRepository;

class QualificationRepository extends ModelRepository implements QualificationRepositoryInterface
{
    /**
     * Model
     * @var Qualification $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Qualification $model
     */
    public function __construct(Qualification $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
