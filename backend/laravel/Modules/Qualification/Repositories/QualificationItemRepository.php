<?php

namespace Modules\Qualification\Repositories;

use Modules\Qualification\Repositories\Interfaces\QualificationItemRepositoryInterface;
use Modules\Qualification\Entities\QualificationItem;
use App\Services\ModelRepository;

class QualificationItemRepository extends ModelRepository implements QualificationItemRepositoryInterface
{
    /**
     * Model
     * @var QualificationItem $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param QualificationItem $model
     */
    public function __construct(QualificationItem $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
