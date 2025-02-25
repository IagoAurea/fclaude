<?php

namespace Modules\Staff\Repositories;

use App\Services\ModelRepository;
use Modules\Staff\Entities\StaffWorkExperience;
use Modules\Staff\Repositories\Interfaces\StaffWorkExperienceRepositoryInterface;

class StaffWorkExperienceRepository extends ModelRepository implements StaffWorkExperienceRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance.
     */
    public function __construct(StaffWorkExperience $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
