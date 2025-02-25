<?php

namespace Modules\Competition\Repositories;

use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionMatchLineup;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchLineupRepositoryInterface;
use App\Services\ModelRepository;

class CompetitionMatchLineupRepository extends ModelRepository implements CompetitionMatchLineupRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(CompetitionMatchLineup $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
