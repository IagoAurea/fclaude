<?php

namespace Modules\User\Repositories;

use Modules\User\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\ModelRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends ModelRepository implements RoleRepositoryInterface
{
    
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}