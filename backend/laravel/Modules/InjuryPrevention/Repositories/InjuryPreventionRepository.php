<?php

namespace Modules\InjuryPrevention\Repositories;

use Illuminate\Support\Facades\DB;
use App\Services\ModelRepository;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionRepositoryInterface;

class InjuryPreventionRepository extends ModelRepository implements InjuryPreventionRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(InjuryPrevention $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieves a list of all players related
     *
     * @return Array
     */
    public function listPlayers($queryParams, $teamId)
    {
        $query = DB::table('injury_preventions')->select(
            DB::raw("ROW_NUMBER() OVER (ORDER BY players.id) AS index"),
            'injury_preventions.id AS injury_prevention_id',
            'players.id AS player_id',
            'resources.url AS player_image',
            'players.full_name',
            'players.gender_id',
            DB::raw("
                (CASE
                    WHEN players.gender_id = '1' THEN 'male'
                    WHEN players.gender_id = '2' THEN 'female'
                    ELSE 'undefined'
                END) AS gender
            "),
            'teams.id AS team_id',
            DB::raw("COALESCE(injury_preventions.profile_status, 'none') AS profile_status"),
            'injury_preventions.title',
            'injury_preventions.created_at',
            'injury_preventions.is_finished',
            DB::RAW("0 as days")
        )
        ->rightJoin('players', 'injury_preventions.player_id', '=', 'players.id')
        ->leftJoin('resources', 'players.image_id', '=', 'resources.id')
        ->join('teams', 'players.team_id', '=', 'teams.id')
        ->where('teams.id', $teamId)
        ->whereNull('players.deleted_at')
        ->orderBy('players.full_name', 'ASC');

        // Player name searching
        if (isset($queryParams['player_name'])) {
            $injuryLocation = strtolower($queryParams['player_name']);
            $query->where('players.full_name', 'ilike', "%$injuryLocation%");
        }

        // Injuery location searching
        if (isset($queryParams['injury_location'])) {
            $location = strtolower($queryParams['injury_location']);
            $query->where('injury_preventions.detailed_location', 'ilike', "%$location%");
        }

        // Preventive program filtering
        if (isset($queryParams['preventive_program_id'])) {
            $query->where('injury_preventions.preventive_program_type_id', $queryParams['preventive_program_id']);
        }

        // Finished value on the injury prevention items
        if (isset($queryParams['is_finished'])) {
            $query->where('injury_preventions.is_finished', $queryParams['is_finished']);
        }

        $players = $query->get();

        $players->map(function ($player) {
            $player->days = DB::table('injury_prevention_week_days')->where('injury_prevention_id',
                $player->injury_prevention_id)->count();

            return $player;
        });

        return $players;
    }

    /**
     * Inserts weekday relations on database
     *
     * @return void
     */
    public function insertWeekDays($injuryId, $weekDays)
    {
        foreach ($weekDays as $weekDay) {
            DB::table('injury_prevention_week_days')->insert([
                'injury_prevention_id' => $injuryId,
                'week_day_id' => $weekDay
            ]);
        }
    }

    /**
     * Deletes a set of weekdays
     *
     * @return void
     */
    public function deleteWeekDays($injuryId)
    {
        DB::table('injury_prevention_week_days')->where(
            'injury_prevention_id', $injuryId
        )->delete();
    }
}
