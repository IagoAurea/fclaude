<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\AcademicPeriodRepositoryInterface;

// Entities
use Modules\Club\Entities\AcademicPeriod;

class AcademicPeriodRepository extends ModelRepository implements AcademicPeriodRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;

    public function __construct(AcademicPeriod $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
