<?php

namespace Modules\Scouting\Repositories;

use App\Services\ModelRepository;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Repositories\Interfaces\ScoutingActivityRepositoryInterface;

class ScoutingActivityRepository extends ModelRepository implements ScoutingActivityRepositoryInterface
{
    /**
     * Model
     * @var ScoutingActivity $model
     */
    protected $model;

    /**
     * Model
     * @var CompetitionMatch $competitionMatchModel
     */
    protected $competitionMatchModel;

    /**
     * Instances a new repository class
     *
     * @param ScoutingActivity $model
     * @param CompetitionMatch $competitionMatchModel
     */
    public function __construct(ScoutingActivity $model, CompetitionMatch $competitionMatchModel)
    {
        $this->model = $model;
        $this->competitionMatchModel = $competitionMatchModel;

        parent::__construct($this->model, ['player']);
    }

    /**
     * Returns the scouting activities
     * associated to a given scouting
     *
     * @param int $scouting_id
     */
    public function getMatchActivities($scouting_id)
    {
        return $this->model
            ->with('action')
            ->where([
                'scouting_id' => $scouting_id,
                'status' => true
            ])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Returns the scouting activities
     * associated to a given scouting
     * for a specific player
     *
     * @param int $scouting_id
     * @param int $player_id
     */
    public function getPlayerMatchActivities($scouting_id, $player_id)
    {
        return $this->model
            ->with('action')
            ->where(['scouting_id' => $scouting_id])
            ->where(['player_id' => $player_id])
            ->get();
    }

    /**
     * Returns the scouting activities
     * associated to a given scouting
     * grouped by player_id
     *
     * @param int $scouting_id
     */
    public function getMatchActivitiesGroupedByPlayers($scouting_id)
    {
        return $this->model
            ->with('action')
            ->where(['scouting_id' => $scouting_id])
            ->where('player_id', '!=', null)
            ->get()
            ->groupBy('player_id');
    }

    /**
     * Returns the latest scouting
     * for a specific player
     *
     * @param int $player_id
     */
    public function latestPlayerScouting($player_id)
    {
        return $this->model
            ->where(['player_id' => $player_id])
            ->latest()
            ->first();
    }
}
