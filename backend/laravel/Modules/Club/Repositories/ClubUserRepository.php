<?php

namespace Modules\Club\Repositories;

// Repositories
use App\Services\ModelRepository;

// Interfaces
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;

// Entities
use Modules\Club\Entities\ClubUser;

class ClubUserRepository extends ModelRepository implements ClubUserRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;

    public function __construct(ClubUser $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}