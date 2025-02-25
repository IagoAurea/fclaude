<?php

namespace Modules\Competition\Repositories;

use Carbon\Carbon;
use App\Services\ModelRepository;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class CompetitionMatchRepository extends ModelRepository implements CompetitionMatchRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * CompetitionMatchRepository constructor.
     * @param CompetitionMatch $model
     */
    public function __construct(CompetitionMatch $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Get next matches by team
     * @param $team_id
     * @return mixed
     */
    public function findAllNextMatchesByTeamId($team_id)
    {
        return $this->model->whereHas('competition', function($q) use ($team_id) {
            $q->where("team_id", $team_id);
        })->whereRaw("start_at > NOW()")
            ->orderBy("start_at", "DESC")
            ->get();
    }

    /**
     * Get Id last match
     * @param $competition_id
     * @return mixed
     */
    public function findLastMatchByCompetition($competition_id)
    {
        return $this->model->where("competition_id",$competition_id)->max("id");
    }

    /**
     * Get all by competition
     * @param $competition_id
     * @return array
     */
    public function findAllByCompetition($competition_id)
    {
        $criteria = ["competition_id" => $competition_id];
        return $this->findBy($criteria);
    }

    /**
     * Get Recent Matches by TeamId
     * @param $team_id
     * @return mixed
     */
    public function findAllRecentMatchesByTeamId($team_id)
    {
        return $this->model
            ->with('competitionRivalTeam', 'competitionMatchRival', 'competition.team')
            ->whereHas('competition', function($query) use ($team_id) {
                $query->where("team_id", $team_id);
            })->whereRaw("start_at < NOW()")
            ->orderBy("start_at", "DESC")
            ->get();
    }

    /**
     * Find all matches regardless the competition identificator
     *
     * @return array
     */
    public function findAllCompetitionMatches($team, $groupType = null)
    {
        $query = $this->model->select('competition_matches.*')
            ->with('weather', 'competitionRivalTeam', 'competitionMatchRival', 'referee')
            ->join('competitions', 'competition_matches.competition_id', '=', 'competitions.id')
            ->where('competitions.team_id', $team->id)
            ->orderBy('competition_matches.start_at', 'asc');

        if ($groupType) {
            $sign = $groupType == 'recent' ? '<' : '>';

            $query->whereTime('competition_matches.start_at', $sign, Carbon::now());
        }

        return $query->get();
    }

    /**
     *
     */
    public function findAllClubTeamsMatches($club, $groupType = null)
    {
        $query = $this->model->select(
            'competition_matches.*',
            'teams.id AS team_id',
            'teams.name AS team_name',
            'teams.club_id',
        )
        ->with(['weather', 'competitionRivalTeam', 'competitionMatchRival', 'referee', 'competition'])
        ->join('competitions', 'competition_matches.competition_id', '=', 'competitions.id')
        ->join('teams', 'competitions.team_id', '=', 'teams.id')
        ->where('teams.club_id', $club->id)
        ->orderBy('competition_matches.start_at', 'asc');

        if ($groupType) {
            $sign = $groupType == 'recent' ? '<' : '>';

            $query->whereTime('competition_matches.start_at', $sign, Carbon::now());
        }

        return $query->get();
    }

       /**
     * Find By Competition Rival Team Id and date Start under current
     * @param $rival_team
     * @return array
     */
    public function findMatchRivalTeamByDateUnderCurrent($rival_team)
    {
        return $this->model
                ->where('competition_rival_team_id', $rival_team)
                ->where('start_at', '<', now())
                ->get();
    }

    /**
     * Retrieve sport id of competition match id
     * @param $competition_match_id
     * @return mixed | integer | null
     */
    public function findSportByCompetitionMatch($competition_match_id)
    {
        $competition_match = $this->model
            ->where('id', $competition_match_id)
            ->with('competition.team.sport')
            ->first();
        
        return $competition_match->competition->team->sport->id ?? NULL;
    }

    /**
     * Retrieve last match player
     *
     * @param $player_id
     */
    public function lastMatchPlayer($player_id)
    {
        $last = $this->model
            ->WhereHas('players', function($query) use($player_id) {
                $query->where('player_id', $player_id);
            })
            ->with(['weather', 'referee', 'modality', 'test_category', 'test_type_category', 'lineup'])
            ->where('start_at', '<', now())
            ->orderBY('start_at', 'DESC')
            ->first();

        if($last) {
            $last->competitionRivalTeam;
            $last->makeHidden(['competition']);
        }

        return $last;
    }
}
