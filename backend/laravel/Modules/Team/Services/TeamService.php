<?php

namespace Modules\Team\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use Modules\Club\Entities\Club;
use Modules\User\Entities\User;
use Modules\Club\Entities\ClubType;
use Modules\User\Services\PermissionService;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class TeamService
{
    const CLUB = 'club';
    const TEAM_LIST = 'club_team_list';

    use ResponseTrait, ResourceTrait;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var object $permissionService
     */
    protected $permissionService;

    /**
     * Create a new service instance
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ClubRepositoryInterface $clubRepository,
        PermissionService $permissionService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->clubRepository = $clubRepository;
        $this->permissionService = $permissionService;

    }

    /**
     * Retrieves full list of players with rfd injury registries
     *
     * @return array
     */
    public function listTeamRDFInjuries(Team $team)
    {
        return $this->teamRepository->listTeamRDFInjuries($team);
    }

    /**
     * Returns information of all teams depending of an specific user
     * @return Team[]
     *
     * @OA\Schema(
     *  schema="TeamListResponse",
     *  type="object",
     *  description="Returns the list of all teams in database depending on the user and club specifications sent",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List Teams"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="slug", type="string", example="string"),
     *          @OA\Property(property="color", type="string", example="string"),
     *          @OA\Property(property="category", type="string", example="string"),
     *          @OA\Property(property="type_id", type="int64", example="1"),
     *          @OA\Property(property="modality_id", type="int64", example="1"),
     *          @OA\Property(property="season_id", type="int64", example="1"),
     *          @OA\Property(property="gender_id", type="int64", example="1"),
     *          @OA\Property(property="image_id", type="int64", example="1"),
     *          @OA\Property(property="cover_id", type="int64", example="1"),
     *          @OA\Property(property="sport_id", type="int64", example="1"),
     *          @OA\Property(property="club_id", type="int64", example="1"),
     *          @OA\Property(property="staff_count", type="int64", example="1"),
     *          @OA\Property(property="created_at", format="date-time", example="2022-01-01 00:00:00"),
     *          @OA\Property(property="image_url", type="string", example="string"),
     *          @OA\Property(property="cover_url", type="string", example="string"),
     *          @OA\Property(
     *              property="type",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="sport",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="code", type="string", example="string"),
     *              @OA\Property(property="name", type="string", example="string"),
     *              @OA\Property(property="has_scouting", type="boolean", example="true"),
     *              @OA\Property(property="model_url", type="string", example="string"),
     *              @OA\Property(property="field_image", type="string", example="string"),
     *          ),
     *          @OA\Property(
     *              property="season",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="start", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="end", type="string", format="date", example="2022-02-01"),
     *              @OA\Property(property="name", type="string", example="string"),
     *              @OA\Property(property="active", type="boolean", example="true"),
     *          ),
     *          @OA\Property(
     *              property="image",
     *              type="object",
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="url", type="string", example="string"),
     *              @OA\Property(property="mime_type", type="boolean", example="true"),
     *              @OA\Property(property="size", type="int64", example="65038"),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function index(User $user, $request, Club $club)
    {
        $teamsId = [];

        if ($user->hasPermissionTo(self::TEAM_LIST)) {
            $permissions = $this->permissionService->listUserPermissions($user->id);

            foreach ($permissions as $detail) {
                if (is_null($detail['entity']) || $detail['entity']['type'] == self::CLUB) { continue; }

                $hasPermissionList = collect($detail['permissions'])->first(function ($element) {
                    return $element['name'] == self::TEAM_LIST;
                });

                if ($hasPermissionList) {
                    array_push($teamsId, $detail['entity']['id']);
                }
            }
        }

        if ($user->id !== $club->user_id && count($teamsId) == 0) {
            return [];
        }

        try {
            return $this->teamRepository->findAllByOwner($user->id, $request, $club->id, $teamsId);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Returns list team user
     *
     * @return array Team
     */
    public function listAllByUser(User $user)
    {
        $clubs = $this->clubRepository->findUserClubs($user->id, ClubType::CLUB_TYPE_SPORT, [], ['teams']);

        $clubs->makeHidden(['users']);

        $total_teams = $clubs->map(function($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->count();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_teams' => $total_teams ?? 0
        ];
    }

    /**
     * Returns information about specific team item
     *
     * @return Team
     */
    public function show($code)
    {
        try {
            $team = $this->findTeam($code);

            $team->image;
            $team->cover;
            $team->club;
            $team->sport;
            $team->season;
            $team->type;
            $team->modality;

            return $team;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Retrieve team by code
     */
    private function findTeam($code)
    {
        $team = $this->teamRepository->findOneBy([
            'code' => $code
        ]);

        if (!$team) {
            throw new Exception('Team not found', Response::HTTP_NOT_FOUND);
        }

        return $team;
    }
}
