<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\Health;
use Modules\Health\Repositories\Interfaces\HealthRepositoryInterface;

class HealthRepository extends ModelRepository implements HealthRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(Health $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function bulkDeleteRelations($entity, $healthClass)
    {
        $this->model->where([
            'entity_id' => $entity->id,
            'entity_type' => get_class($entity),
            'health_entity_type' => $healthClass,
        ])->delete();
    }
}
