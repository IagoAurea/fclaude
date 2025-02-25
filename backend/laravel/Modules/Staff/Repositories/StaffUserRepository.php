<?php

namespace Modules\Staff\Repositories;

use App\Services\ModelRepository;
use Modules\Staff\Entities\StaffUser;
use Modules\Staff\Repositories\Interfaces\StaffUserRepositoryInterface;

class StaffUserRepository extends ModelRepository implements StaffUserRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance.
     */
    public function __construct(StaffUser $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
