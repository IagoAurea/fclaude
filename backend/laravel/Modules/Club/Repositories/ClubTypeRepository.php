<?php

namespace Modules\Club\Repositories;

use App\Services\ModelRepository;
use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubTypeRepositoryInterface;

class ClubTypeRepository extends ModelRepository implements ClubTypeRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(ClubType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
