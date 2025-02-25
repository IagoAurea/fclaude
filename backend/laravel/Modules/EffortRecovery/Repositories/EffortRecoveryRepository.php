<?php

namespace Modules\EffortRecovery\Repositories;

use Illuminate\Support\Facades\DB;

use App\Services\ModelRepository;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryRepositoryInterface;

class EffortRecoveryRepository extends ModelRepository implements EffortRecoveryRepositoryInterface
{
     /**
     * @var object
    */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(EffortRecovery $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    /**
     * Retrieve last effort recovery by player
     */
    public function lastEffortRecoveryByPlayer($player_id)
    {
        return $this->model
            ->where('player_id', $player_id)
            ->with('latestQuestionnaireHistory')
            ->latest()
            ->first();
    }

    /**
     * Returns a list of players
     *
     * @return array
     */
    public function listPlayers($teamId, $queryParams)
    {
        $query = $this->_model->select(
            'players.id AS player_id',
            'players.full_name',
            'players.gender_id',
            'resources.url as player_url',
            DB::raw("
                (CASE
                    WHEN players.gender_id = 1 THEN 'male'
                    WHEN players.gender_id = 2 THEN 'female'
                    ELSE 'undefined'
                END) AS gender
            "),
            'effort_recovery.id AS effort_recovery_id',
            DB::raw('COALESCE(effort_recovery.has_strategy, FALSE) AS has_strategy'),
            'effort_recovery.created_at',
        )
        ->rightJoin('players', 'effort_recovery.player_id', '=', 'players.id')
        ->leftJoin('resources', 'players.image_id', '=', 'resources.id')
        ->where('players.team_id', $teamId)
        ->whereNull('players.deleted_at')
        ->orderBy('players.full_name', 'ASC')
        ->orderBy('effort_recovery_id', 'DESC')
        ->distinct('players.full_name');

        // // Player name searching
        if (isset($queryParams['player_name'])) {
            $playerName = strtolower($queryParams['player_name']);
            $query->where('players.full_name', 'ilike', "%$playerName%");
        }
        
        return $query->get();
    }
   
   
    /**
     * Returns a list of players V1
     * 
     * @return array
     */
    public function listPlayersV1($teamId, $queryParams)
    {
        $query = $this->_model->select(
            'players.id AS player_id',
            'players.full_name',
            'players.gender_id',
            'resources.url as player_url',
            DB::raw("
                (CASE
                    WHEN players.gender_id = 1 THEN 'male'
                    WHEN players.gender_id = 2 THEN 'female'
                    ELSE 'undefined'
                END) AS gender
            "),
            'effort_recovery.id AS effort_recovery_id',
            DB::raw('COALESCE(effort_recovery.has_strategy, FALSE) AS has_strategy'),
            'effort_recovery.created_at',
        )
        ->rightJoin('players', 'effort_recovery.player_id', '=', 'players.id')
        ->leftJoin('resources', 'players.image_id', '=', 'resources.id')
        ->leftJoin('wellness_questionnaire_history', 'effort_recovery.id', '=', 'effort_recovery_id')
        ->where('players.team_id', $teamId)
        ->orderBy('players.full_name', 'ASC');

        // // Player name searching
        if (isset($queryParams['player_name'])) {
            $playerName = strtolower($queryParams['player_name']);
            $query->where('players.full_name', 'ilike', "%$playerName%");
        }

        // Injury location searching
        // if (isset($queryParams['strategy_id'])) {
        //     $strategy = strtolower($queryParams['strategy_id']);
        //     $query->where('effort_recovery_strategies.id', $strategy);
        // }
        
        return $query->get();
    }
}
