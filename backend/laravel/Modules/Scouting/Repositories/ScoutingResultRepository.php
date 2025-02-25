<?php

namespace Modules\Scouting\Repositories;

use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Scouting\Entities\ScoutingResult;
use App\Services\ModelRepository;

class ScoutingResultRepository extends ModelRepository implements ScoutingResultRepositoryInterface
{
    /**
     * Model
     * @var ScoutingResult $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param ScoutingResult $model
     */
    public function __construct(ScoutingResult $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
