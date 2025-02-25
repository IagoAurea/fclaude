<?php

namespace Modules\Competition\Repositories;

use Modules\Competition\Entities\Competition;
use App\Services\ModelRepository;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Competition\Repositories\Interfaces\CompetitionRivalTeamRepositoryInterface;

class CompetitionRivalTeamRepository extends ModelRepository implements CompetitionRivalTeamRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(CompetitionRivalTeam $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Find By Competition Id
     * @param $competition_id
     * @return array
     */
    public function findAllByCompetitionId($competition_id)
    {
        $search = [
            "competition_id" => $competition_id
        ];

        return $this->findBy($search);
    }
}
