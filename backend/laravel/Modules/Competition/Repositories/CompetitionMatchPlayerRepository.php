<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionMatchPlayer;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;

class CompetitionMatchPlayerRepository extends ModelRepository implements CompetitionMatchPlayerRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;
    /**
     * @var object
     */
    protected $competition_match_model;

    public function __construct(CompetitionMatchPlayer $model, CompetitionMatch $competition_match_model)
    {
        $this->model = $model;
        $this->competition_match_model = $competition_match_model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve played games by player in match
     */
    public function playedGamesByPlayer($player_id)
    {
        return $this->model
            ->where('player_id', $player_id)
            ->with(['competitionMatch', 'perceptEffort', 'competitionMatch.rivals', 'competitionMatch.competitionRivalTeam', 'competitionMatch.competitionMatchRival'])
            ->whereHas('competitionMatch', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->get();
    }

    /**
     * Retrieve RPE last match of player
     */
    public function rpeLastMatchPlayer($player_id)
    {
        return $this->model
            ->where('player_id', $player_id)
            ->whereHas('competitionMatch')
            ->with('competitionMatch', function($query) {
                $query->where('start_at', '<', now());
                $query->orderBY('start_at', 'DESC');
            })
            ->whereHas('perceptEffort')
            ->with('perceptEffort')
            ->first();
    }

    public function playedGamesByCompetition($competition_id, $player_id)
    {
        $competition_matches = $this
            ->competition_match_model
            ->where(['competition_id' => $competition_id])
            ->select('id')
            ->get()
            ->pluck('id');

        $played_games = $this
            ->model
            ->whereIn('competition_match_id', $competition_matches)
            ->where('player_id', $player_id)
            ->with('competitionMatch')
            ->get();

        return $played_games;
    }

    /**
     * Retrieve number matches player
     */
    public function countMatchesPlayer($player_id)
    {
        return $this->model
            ->where('player_id', $player_id)
            ->count();
    }
}
