<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;

// Entities
use Modules\Club\Entities\AcademicYear;

class AcademicYearRepository extends ModelRepository implements AcademicYearRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;

    public function __construct(AcademicYear $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
