<?php

namespace Modules\Team\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Club\Entities\Club;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Team\Services\TeamService;
use Modules\Club\Services\ClubService;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Modules\Team\Http\Requests\IndexTeamRequest;
use Modules\Team\Http\Requests\StoreTeamRequest;
use Modules\Team\Http\Requests\UpdateTeamRequest;
use Modules\Generality\Services\ResourceService;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class TeamController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var $teamRepository
     */
    protected $teamRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $teamService
     */
    protected $teamService;

    /**
     * @var $clubService
     */
    protected $clubService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService,
        TeamService $teamService,
        ClubService $clubService,
    ) {
        $this->teamRepository = $teamRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
        $this->teamService = $teamService;
        $this->clubService = $clubService;
    }

    /**
     * Display a listing of teams of user.
     * @return Response
     * @OA\Get(
     *  path="/api/v1/teams/list/user",
     *  tags={"Team"},
     *  summary="Get list all teams of user - Lista de todos los equipos del usuario",
     *  operationId="list-team-user",
     *  description="Return data list all team of user - Retorna listado de todos los equipos del usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Team listing response",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/TeamListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function listTeamsByUser()
    {
        $teams = $this->teamService->listAllByUser(Auth::user());

        return $this->sendResponse($teams, $this->translator('team_controller_list_response_message'));
    }

    /**
     * Display a listing of team type.
     * @return Response
     * @OA\Get(
     *  path="/api/v1/teams/{club_id}",
     *  tags={"Team"},
     *  summary="Get list Teams - Lista de equipos",
     *  operationId="list-team",
     *  description="Return data list team  - Retorna listado de equipos",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id_nr" ),
     *  @OA\Parameter( ref="#/components/parameters/sport_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Team listing response",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/TeamListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Club $club, IndexTeamRequest $request)
    {
        $teams = $this->teamService->index(Auth::user(), $request, $club);

        return $this->sendResponse($teams, $this->translator('team_controller_list_response_message'));
    }

    /**
     * Display a listing of player by team.
     * @return Response
     * @OA\Get(
     *  path="/api/v1/teams/players/{code}",
     *  tags={"Team"},
     *  summary="Get list players by Teams - Lista de jugadores por equipo",
     *  operationId="list-players-team",
     *  description="Return data list players by team  - Retorna listado de jugadores por equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getPlayersByTeam($code)
    {
        $team =  $this->teamRepository->findOneBy(["code" => $code]);

        if (!$team) {
            return $this->sendError("Error", "Team not found", Response::HTTP_NOT_FOUND);
        }

        $teams = $this->teamRepository->findAllPlayersByTeam($team->id);

        return $this->sendResponse($teams, 'List of Players By team');
    }

    /**
     * Store a new Team.
     * @param StoreTeamRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/teams",
     *  tags={"Team"},
     *  summary="Stored Team - guardar un nuevo equipo ",
     *  operationId="team-store",
     *  description="Store a new team - Guarda un nuevo equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreTeamRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(StoreTeamRequest $request)
    {
        $permission = Gate::inspect('store-team', $request->club_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();

            $teamData = $request->except('image', 'cover');

            $teamData['user_id'] = $user->id;

            if ($request->image) {
                $dataResource = $this->uploadResource('/teams', $request->image);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $teamData['image_id'] = $resource->id;
                }
            }

            if ($request->cover) {
                $dataResource = $this->uploadResource('/teams', $request->cover);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $teamData['cover_id'] = $resource->id;
                }
            }

            $team = $this->teamRepository->create($teamData);

            DB::commit();

            $ownerClub = $this->clubService->ownerClub($request->club_id);

            if ($ownerClub->id == $user->id) {
                $permissions = collect(config('permission.names'))
                        ->where('entity_code', '!=', 'club')
                        ->all();

                $permissionCodes = [];

                foreach ($permissions as $permission) {
                    $permissionCodes = array_merge($permissionCodes, $permission['codes']);
                }
            } else {
                $permissionCodes = ['club_team_store', 'club_team_read'];
            }

            $user->assignMultiplePermissions($permissionCodes, $team->id, get_class($team));

            event(new ActivityEvent(Auth::user(), $team->club, 'team_created', $team));

            $team->sport;
            
            return $this->sendResponse(
                $team, $this->translator('team_controller_store_response_message'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            DB::rollback();
            return $this->sendError('Error by creating Team', $exception->getMessage());
        }
    }

    /**
     * Shows information about team depending on the code sent.
     * @param int $code
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/teams/{code}/show",
     *   tags={"Team"},
     *   summary="Show team - Ver los datos de un equipo",
     *   operationId="show-team",
     *   description="Return data to team  - Retorna los datos de un equipo",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Parameter( ref="#/components/parameters/code" ),
     *   @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show($code)
    {
        try {
            $team = $this->teamService->show($code);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Team', $exception->getMessage());
        }
        
        $permission = Gate::inspect('read-team', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        return $this->sendResponse($team, $this->translator('team_controller_show_response_message'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateTeamRequest $request
     * @param int $code
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/teams/{code}",
     *  tags={"Team"},
     *  summary="Edit team - Editar un equipo",
     *  operationId="team-edit",
     *  description="Edit a team - Edita un equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/UpdateTeamRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateTeamRequest $request, $code)
    {
        $team =  $this->teamRepository->findOneBy(["code" => $code]);

        if (!$team) { return $this->sendError('Team not found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND); }

        $permission = Gate::inspect('update-team', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        DB::beginTransaction();

        $teamData = $request->except('image', 'cover');

        try {
            if ($request->image) {
                $dataResource = $this->uploadResource('/teams', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $teamData['image_id'] = $resource->id;
                }
            }

            if ($request->cover) {
                $dataResource = $this->uploadResource('/teams', $request->cover);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $teamData['cover_id'] = $resource->id;
                }
            }

            $this->teamRepository->update($teamData, ["id" => $team->id]);

            if ($request->image && $team->image_id) {
                $this->resourceService->deleteResourceData($team->image_id);
            }

            if ($request->cover && $team->cover_id) {
                $this->resourceService->deleteResourceData($team->cover_id);
            }

            event(new ActivityEvent(Auth::user(), $team->club, 'team_updated', $team));

            DB::commit();

            $teamData = $this->teamRepository->find($team->id);

            return $this->sendResponse($teamData, $this->translator('team_controller_update_response_message'));
        } catch (Exception $exception) {
            DB::rollback();
            return $this->sendError('An error has occurred', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/teams/cover/{code}",
     *       tags={"Team"},
     *       summary="Edit cover - Editar portada",
     *       operationId="team-cover-edit",
     *       description="Edit a cover - Edita portada",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response=422,
     *           ref="#/components/responses/unprocessableEntity"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $code
     * @return Response
     */
    public function updateCover(Request $request, $code)
    {
        $team =  $this->teamRepository->findOneBy(['code' => $code]);

        if (!$team) { return $this->sendError('Team not found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND); }

        $teamData = [];

        try {
            if ($request->cover) {
                $dataResource = $this->uploadResource('/teams', $request->cover);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $teamData['cover_id'] = $resource->id;
                }
            }

            $teamData = $this->teamRepository->update($teamData, [
                'id' => $team->id
            ]);

            if ($request->cover && $team->cover_id) {
                $this->resourceService->deleteResourceData($team->cover_id);
            }

            event(new ActivityEvent(Auth::user(), $team->club, 'team_updated', $team));

            return $this->sendResponse($teamData, 'Team cover updated!');
        } catch (Exception $exception) {
            return $this->sendError('An error has occurred', $exception->getMessage());
        }
    }

    /**
     *
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/teams/{code}",
     *  tags={"Team"},
     *  summary="Delete team- Elimina un  equipo",
     *  operationId="team-delete",
     *  description="Delete a team - Elimina un equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function destroy($code)
    {
        $team =  $this->teamRepository->findOneBy(['code' => $code]);
        
        if (!$team) {
            return $this->sendError('Error', 'Team not found', Response::HTTP_NOT_FOUND);
        }

        $permission = Gate::inspect('delete-team', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            if ($team->image_id) {
                $this->resourceService->deleteResourceData($team->image_id);
            }

            $this->teamRepository->delete($team->id);

            event(new ActivityEvent(Auth::user(), $team->club, 'team_deleted', $team));

            return $this->sendResponse(
                null, $this->translator('team_controller_delete_response_message'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Team', $exception->getMessage());
        }
    }
}
