<?php

namespace Modules\Player\Repositories;

use Modules\Player\Repositories\Interfaces\PlayerContractRepositoryInterface;
use Modules\Player\Entities\PlayerContract;
use App\Services\ModelRepository;

class PlayerContractRepository extends ModelRepository implements PlayerContractRepositoryInterface
{
    public function __construct(PlayerContract $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}