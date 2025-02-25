<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;

// Entities
use Modules\Club\Entities\WorkingExperiences;

// Extra
use Illuminate\Support\Facades\DB;

class WorkingExperiencesRepository extends ModelRepository implements WorkingExperiencesRepositoryInterface
{
        /** 
     * @var object
     */
    protected $model;

    public function __construct(WorkingExperiences $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @return Object Returns an existing staff 
     */
    public function getWorkingExperiencesById($id,$staff_id) 
    {
        // Search for the first item that matches 
        $item = $this->model
            ->where('id',$id)
            ->where('staff_id',$staff_id)
            ->first();

        if (!$item) {
            throw new \Exception("Working Experiences not found");
        }

        return $item;
    }
}