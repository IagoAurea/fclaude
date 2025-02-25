<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\ClubUserTypeRepositoryInterface;

// Entities
use Modules\Club\Entities\ClubUserType;

class ClubUserTypeRepository extends ModelRepository implements ClubUserTypeRepositoryInterface
{
        /** 
     * @var object
     */
    protected $model;

    public function __construct(ClubUserType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function getUserTypeByName($name) 
    {
        // Search for the first item that matches the WHERE clausules
        $item = $this->model->where(
            'name', $name
        )->first();

        if (!$item) {
            throw new \Exception("Staff not found");
        }

        return $item;
    }

}