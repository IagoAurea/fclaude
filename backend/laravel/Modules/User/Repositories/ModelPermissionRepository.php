<?php

namespace Modules\User\Repositories;

use Modules\Club\Entities\Club;
use Modules\Team\Entities\Team;
use App\Services\ModelRepository;
use Modules\User\Entities\ModelPermission;
use Modules\User\Repositories\Interfaces\ModelPermissionRepositoryInterface;

class ModelPermissionRepository extends ModelRepository implements ModelPermissionRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(ModelPermission $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Returns a list of permissions depending on the user_id sent
     *
     * @return array
     */
    public function listUserPermissions($userId, $entityId = null, $entityType = null)
    {
        // Add more search cases when is an entity is related
        if (isset($entityType)) {
            $type = $entityType == 'club' ? Club::class : Team::class;

            return $this->model->select('*')
                ->where('model_id', $userId)
                ->when($entityId != null, function ($query) use ($entityId) {
                    $query->where('entity_id', $entityId);
                })
                ->where('entity_type', $type)
                ->with('permission')
                ->get();
        }

        return $this->model->select('*')
            ->where('model_id', $userId)
            ->with('permission')
            ->get();
    }

    /**
     * Retrireves a list of permission relation models
     *
     * @param string $entityType
     * @param string $entityId
     * @param mixed $extraIds
     */
    public function listEntityPermissions($entityType, $entityId, $extraIds = null)
    {
        $type = $entityType == 'club' ? 'Modules\Club\Entities\Club' : 'Modules\Team\Entities\Team';

        return $this->model->select('*')
            ->whereIn('entity_id', $extraIds)
            ->get();
    }
}
