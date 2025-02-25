<?php

namespace Modules\User\Repositories;

use App\Services\ModelRepository;
use Modules\User\Entities\Permission;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends ModelRepository implements PermissionRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Lists permissions grouped by specific functionality
     *
     * @return array
     */
    public function listPermissions()
    {
        return $this->model->select('*')
            ->whereNotNull('entity_code')
            ->get();
    }
}
