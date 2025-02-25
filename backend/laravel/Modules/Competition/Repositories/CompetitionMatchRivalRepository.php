<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\CompetitionMatchRival;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRivalRepositoryInterface;

class CompetitionMatchRivalRepository extends ModelRepository implements CompetitionMatchRivalRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(CompetitionMatchRival $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}
