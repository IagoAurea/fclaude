<?php

namespace Modules\Player\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Player\Entities\Player;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\DB;
use Modules\Test\Entities\Test;

class PlayerRepository extends ModelRepository implements PlayerRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(Player $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Return list players with last effort recovery
     */
    public function lastEffortRecovery($team, $queryParams)
    {
        return $this->_model
            ->select('id', 'full_name', 'gender_id', 'team_id', 'image_id')
            ->with('latestEffortRecovery')
            ->where('team_id', $team)
            ->when(isset($queryParams['player_name']), function ($query) use ($queryParams) {
                $name = $queryParams['player_name'];
                return $query->where('full_name', 'ilike', "%$name%");
            })
            ->orderBy('full_name', 'asc')
            ->get();
    }

    /**
     * Return list players with last file
     */
    public function lastFileFisiotherapy($team, $queryParams)
    {
        return $this->_model
            ->select('id', 'full_name', 'gender_id', 'team_id', 'alias', 'image_id')
            ->with('latestFileFisiotherapy', function ($query) use ($queryParams) {
                $query->with('teamStaff', function ($q) use ($queryParams) {
                    $q->when(isset($queryParams['team_staff_name']), function ($q) use ($queryParams) {
                        $staffName = strtolower($queryParams['team_staff_name']);
                        return $q->where('full_name', 'ilike', "%$staffName%");
                    })->when(isset($queryParams['team_staff_id']), function ($q) use ($queryParams) {
                        return $q->where('id', $queryParams['team_staff_id']);
                    });
                })->when(isset($queryParams['start_date']), function ($q) use ($queryParams) {
                    return $q->where('id', $queryParams['start_date']);
                });
            })
            ->where('team_id', $team)
            ->when(isset($queryParams['player_name']), function ($query) use ($queryParams) {
                $name = $queryParams['player_name'];
                return $query->where('full_name', 'ilike', "%$name%");
            })
            ->orderBy('full_name', 'asc')
            ->get();
    }

    /**
     * Return players by team exclude players
     */
    public function findPlayersByTeamAndExclude($search, $exclude, $relations = [])
    {
        $query = $this->_model
            ->where($search)
            ->whereNotIn('id', $exclude);

        if (count($relations) > 0) {
            $query->with($relations);
        }

        return $query->get();
    }

    /**
     * @return array of laterities
     */
    public function getLateritiesTypes()
    {
        $laterities = Player::getLateritiesTypes();

        array_walk($laterities, function (&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $laterities;
    }

    /**
     * Return players by team
     * @param $filters
     * @param $team_id
     * @return Builder[]|Collection
     */
    public function allPlayersTestByTeam($team_id)
    {
        $query = $this->model
            ->select('id', 'full_name', 'image_id', 'gender_id', 'shirt_number')
            ->with('team', 'image', 'latestTestApplication')
            ->with('latestTestApplication', function ($query) {
                $query->where('applicable_type', Test::class);
                $query->with('test');
            })
            ->where("team_id", $team_id)
            ->withCount(['testApplications' => function ($query) {
                $query->where('applicable_type', Test::class);
            }])
            ->orderBy("full_name", "ASC");

        return $query->get();
    }

    /**
     * Return players with report psycology
     * @param $filters
     * @param $team_id
     * @return Builder[]|Collection
     */
    public function getPlayersWithPsychologyDataByTeam($filters, $team_id)
    {
        $query = $this->model->with('team', 'image', 'psychologyReports')
            ->where("team_id", $team_id)
            ->orderBy("full_name", "ASC");

        $result = $this->applyFilters($query, $filters);

        return $result->get();
    }

    /**
     * Applying filters
     * @param $query
     * @param $filters
     * @return mixed
     */
    private function applyFilters($query, $filters)
    {
        if ($filters->type && $filters->value) {
            if ($filters->type === "player") return $this->filterByPlayer($query, $filters->value);
            if ($filters->type === "staff") return $this->filterByStaff($query, $filters->value);
            if ($filters->type === "date") return $this->filterByDate($query, $filters->value);
        }
        return $query;
    }

    /**
     * Filter by staff field
     * @param $query
     * @param $value
     * @return mixed
     */
    private function filterByStaff($query, $value)
    {
        return $query->where(function ($q) use ($value) {
            $q->whereHas("psychologyReports", function ($q2) use ($value) {
                $q2->where("team_staff_name", "like", "%{$value}%")
                    ->orWhere("staff_name", "like", "%{$value}%");
            });
        });
    }

    /**
     * Filter by date field
     * @param $query
     * @param $value
     * @return mixed
     */
    private function filterByDate($query, $value)
    {
        return $query->where("date", $value);
    }

    /**
     * Filter by player field
     * @param $query
     * @param $value
     * @return mixed
     */
    private function filterByPlayer($query, $value)
    {
        return $query->whereRaw("LOWER(full_name) LIKE ?", ["%" . trim(strtolower($value)) . "%"]);
    }

    /**
     * Retrieves players with specific file relationship array
     *
     * @param int $teamId
     * @return array
     */
    public function getPlayersWithFisiotherapyData($teamId)
    {
        return $this->model::select(
            'id',
            'full_name',
            'alias',
            'shirt_number'
        )->with([
            'files' => function ($query) {
                return $query->orderBy('discharge_date', 'desc');
            }
        ])->where(
            'team_id',
            $teamId
        )->get();
    }

    /**
     * 
     */
    public function listByRecoveryEffort($teamId)
    {
        $players = $this->model::select(
            'players.id',
            'full_name',
            'effort_recovery.id AS effort_recovery_id',
        )->where(
            'team_id',
            $teamId
        )->leftJoin(
            'effort_recovery',
            'players.id',
            '=',
            'effort_recovery.player_id'
        )->with(
            'effortRecoveries'
        )->get();

        foreach ($players as $player) {
            $player->setAppends([]);
        }

        return $players;
    }
}
