<?php

namespace Modules\Scouting\Repositories;

use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Exceptions\CompetitionMatchNotProvidedException;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Scouting\Exceptions\ScoutingStatusForbiddenException;
use Modules\Scouting\Exceptions\ScoutingStatusUpdateException;
use Modules\Scouting\Exceptions\ScoutingNotFoundException;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Entities\Scouting;
use App\Services\ModelRepository;
use Carbon\Carbon;

class ScoutingRepository extends ModelRepository implements ScoutingRepositoryInterface
{
    /**
     * Model
     * @var Scouting $model
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
     * @param Scouting $model
     * @param CompetitionMatch $competitionMatchModel
     */
    public function __construct(Scouting $model, CompetitionMatch $competitionMatchModel)
    {
        $this->model = $model;
        $this->competitionMatchModel = $competitionMatchModel;

        parent::__construct($this->model);
    }

    /**
     * Get next matches by team
     * 
     * @param int $team_id
     * @param array $filters
     * @return mixed
     */
    public function findAllNextMatchesToScoutByTeam($team_id, $filters = [])
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', now());

        $date = isset($filters['timezone']) ? $now->setTimezone($filters['timezone']): $now;


        $result = $this->competitionMatchModel->with('lineup')
            ->whereHas('competition', function ($q) use ($team_id) {
            $q->where('team_id', $team_id);
        })
            ->with('competition.team')
            ->with('competition.team.sport')
            ->with('competition.team.sport.court')
            ->when(empty($filters), function ($query) {
                return $query->orderBy('start_at', 'DESC');
            })
            ->when(isset($filters['orderByDate']), function ($query) use ($filters) {
                return $query->orderBy('start_at', $filters['orderByDate']);
            })
            ->when(!isset($filters['filterByDate']) && !isset($filters['history']), function ($query) use($date) {
                return $query->where('start_at', '>', $date);
            })
            ->when(isset($filters['filterByDate']), function ($query) use ($filters) {
                return $query->where('start_at', '>=', Carbon::parse($filters['filterByDate']));
            })
            ->when(isset($filters['history']), function ($query) use($date){
                return $query->where('start_at', '<', $date);
            })
            ->when(isset($filters['filterByCompetition']), function ($query) use ($filters) {
                return $query->whereHas('competition', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', '%' . $filters['filterByCompetition'] . '%');
                });
            })
            ->get();

        if (isset($filters['orderByCompetition'])) {
            if ($filters['orderByCompetition'] == 'DESC') {
                $result = $result->sortByDesc('competition_name');
            } else {
                $result = $result->sortBy('competition_name');
            }
        }

        return $result;
    }

    /**
     * Finds a scout by a given competition match
     * or create it if not found
     * 
     * @param int $competition_match_id
     * @param int $scouting_id
     * @throws CompetitionMatchNotProvidedException
     * @throws CompetitionMatchNotFoundException
     * @return mixed
     */
    public function findOrCreateScout($competition_match_id, $scouting_id = null)
    {
        if (!$competition_match_id) {
            throw new CompetitionMatchNotProvidedException;
        }

        if ($scouting_id) {
            $scouting = $this->find($scouting_id);
        } else {
            $competition_match = $this->competitionMatchModel->find($competition_match_id);
            if (!$competition_match) {
                throw new CompetitionMatchNotFoundException;
            }
            $scouting = $this->findOneBy(['competition_match_id' => $competition_match->id]);
        }

        if (!$scouting) {
            $payload = ['competition_match_id' => $competition_match_id, 'status' => Scouting::STATUS_NOT_STARTED];
            $scouting = $this->create($payload);
        }

        return $scouting;
    }

    /**
     * Change status of a scouting to
     * STARTED, PASUED, or FINISHED
     * 
     * @param int $scouting
     * @param int $status
     * @throws ScoutingNotFoundException
     * @throws ScoutingStatusForbiddenException
     * @throws ScoutingStatusUpdateException
     * @return mixed
     */
    public function changeStatus($scouting, $status, $request = [])
    {
        $statuses = [
            Scouting::STATUS_STARTED, Scouting::STATUS_PAUSED, Scouting::STATUS_FINISHED];

        if (!$scouting instanceof Scouting) {
            $scouting = $this->find($scouting);
            if (!$scouting) {
                throw new ScoutingNotFoundException;
            }
        }

        if (!in_array($status, $statuses)) {
            throw new ScoutingStatusForbiddenException;
        }

        if ($scouting) {

            $payload = ['status' => $status];

            if($status == Scouting::STATUS_STARTED) {
                $payload['start_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }

            if($status == Scouting::STATUS_FINISHED) {
                $payload['finish_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }

            foreach($request as $field => $value) {
                $payload[$field] = $value;
            }

            $response = $this->update($payload, $scouting);
        }

        if (!$response) {
            throw new ScoutingStatusUpdateException;
        }

        return $this->find($scouting->id);
    }

    /**
     * Getter forr the sport associated to
     * the given scouting
     * 
     * @param mixed $scouting
     * @throws ScoutingNotFoundException
     * @return mixed
     */
    public function getSport($scouting)
    {
        if (!$scouting instanceof Scouting) {
            $scouting = $this->find($scouting);
            if (!$scouting) {
                throw new ScoutingNotFoundException;
            }
        }

        return $scouting->competitionMatch->competition->team->sport;
    }
}
