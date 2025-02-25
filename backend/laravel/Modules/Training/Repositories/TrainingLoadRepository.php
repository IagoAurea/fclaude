<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\TrainingLoad;
use Modules\Training\Repositories\Interfaces\TrainingLoadRepositoryInterface;

class TrainingLoadRepository extends ModelRepository implements TrainingLoadRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(TrainingLoad $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findOneByRangeDate($entity, $id, $today)
    {
        return $this->model->where('entity_type', $entity)
        ->where('entity_id', $id)
        ->where(function ($query) use ($today) {
            $query->where('from', '<=', $today)
            ->where('to', '>=', $today);
        })
        ->first();
    }

}