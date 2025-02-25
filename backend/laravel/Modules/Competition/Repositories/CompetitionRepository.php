<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;

class CompetitionRepository extends ModelRepository implements CompetitionRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;
        
    /**
     * @var array
     */
    protected $relations;

    public function __construct(Competition $model)
    {
        $this->model = $model;

        $this->relations = ['image'];
        
        parent::__construct($this->model, $this->relations);
    }

    /**
     * @param $team_id
     * @param null $filter "string data for filtering"
     */
    public function findAllByTeamId($team_id, $filter = null)
    {
        $query = $this->model->with('image')->where("team_id", $team_id);

        if ($filter !== null) {
            $query = $query->where("name","like","%$filter%");
        }

        return $query->get();
    }

    /**
     * Find matches by team
     * 
     * @return array
     */
    public function findMatchesByTeam($team_id)
    {
        return $this->model->select('id', 'team_id', 'date_start', 'date_end')
            ->with('matches')
            ->where("team_id", $team_id)
            ->get();
    }

}
