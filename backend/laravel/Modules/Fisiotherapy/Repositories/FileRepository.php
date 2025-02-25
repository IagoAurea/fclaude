<?php

namespace Modules\Fisiotherapy\Repositories;

use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Fisiotherapy\Entities\File;
use Modules\Fisiotherapy\Repositories\Interfaces\FileRepositoryInterface;

class FileRepository extends ModelRepository implements FileRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(File $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieves a list of all files available from all players related
     * to a team, it repeats the player information as many active file
     * it has related
     *
     * @return array
     */
    public function getTeamFiles($queryParams, $teamId)
    {
        $query = (new File)->newQuery();

        // Retrieve all files
        $query->select(
            // Player related columns
            'players.id',
            'players.full_name',
            'players.alias',
            'players.shirt_number',
            'players.image_id',
            'players.gender_id',
            DB::raw("
                (CASE
                    WHEN players.gender_id = '1' THEN 'male'
                    WHEN players.gender_id = '2' THEN 'female'
                    ELSE 'undefined'
                END) AS gender
            "),
            'resources.url',

            // File related columns
            'files.id AS file_id',
            'files.title AS file_title',
            'files.specialty AS specialty',
            'files.medication AS file_medication',
            'files.start_date AS file_start_date',
            'files.deleted_at AS file_delete_date',
            'files.discharge_date AS file_discharge_date',

            // Staff related coluns
            'staff_users.id AS team_staff_id',
            'staff_users.full_name AS team_staff_full_name',
        )
            ->rightJoin('players', 'players.id', '=', 'files.player_id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->leftjoin('resources', 'players.image_id', '=', 'resources.id')
            ->leftJoin('staff_users', 'files.team_staff_id', '=', 'staff_users.id')
            ->where('teams.id', $teamId)
            ->whereNull('players.deleted_at')
            ->withTrashed()
            ->orderBy('players.full_name', 'asc');

        // Check parameters filtering
        if ($queryParams) {
            if (isset($queryParams['player_name'])) {
                $query->orderBy('players.full_name', $queryParams['player_name']);
            }

            // Start date ordering
            if (isset($queryParams['start_date'])) {
                $query->orderBy('files.start_date', $queryParams['start_date']);
            }

            // Staff name searching
            if (isset($queryParams['team_staff_name'])) {
                $staffName = strtolower($queryParams['team_staff_name']);
                $query->where('staff_users.full_name', 'ilike', "%$staffName%");
            }

            // Staff id parsing
            if (isset($queryParams['team_staff_id'])) {
                $query->where('staff_users.id', $queryParams['team_staff_id']);
            }

            // Only active files
            if (isset($queryParams['only_active'])) {
                if ($queryParams['only_active'] == 'true') {
                    $query->whereNotNull('files.id');
                } else {
                    $query->whereNull('files.id');
                }
            }
        }

        // Retrieve all the files
        $files = $query->get();

        // Unset appended model values
        $files->each(function ($file) {
            $file->setAppends([]);
        });

        return $files;
    }
}
