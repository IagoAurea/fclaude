<?php

namespace Modules\Qualification\Repositories;

use Modules\Qualification\Repositories\Interfaces\QualificationResultRepositoryInterface;
use Modules\Qualification\Entities\QualificationResult;
use Illuminate\Support\Facades\DB;
use App\Services\ModelRepository;

class QualificationResultRepository extends ModelRepository implements QualificationResultRepositoryInterface
{
    /**
     * Model
     * @var QualificationResult $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param QualificationResult $model
     */
    public function __construct(QualificationResult $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
