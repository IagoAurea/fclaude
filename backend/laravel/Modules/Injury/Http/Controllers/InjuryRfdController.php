<?php

namespace Modules\Injury\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Team\Services\TeamService;
use Modules\Injury\Services\RfdService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Http\Requests\ShowInjuryRfdRequest;
use Modules\Injury\Http\Requests\StoreInjuryRfdRequest;
use Modules\Injury\Http\Requests\DeleteInjuryRfdRequest;
use Modules\Injury\Http\Requests\UpdateInjuryRfdRequest;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;

class InjuryRfdController extends BaseController
{
    use TranslationTrait;
    /**
     * @var $rfdRepository
     */
    protected $rfdRepository;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $rfdService
     */
    protected $rfdService;

    /**
     * @var $situationRepository
     */
    protected $situationRepository;

    /**
     * @var object $teamService
     */
    protected $teamService;

    public function __construct(
        InjuryRfdRepositoryInterface $rfdRepository,
        RfdService $rfdService,
        CurrentSituationRepositoryInterface $situationRepository,
        PlayerRepositoryInterface $playerRepository,
        TeamService $teamService
    ) {
        $this->rfdRepository = $rfdRepository;
        $this->rfdService = $rfdService;
        $this->situationRepository = $situationRepository;
        $this->playerRepository = $playerRepository;
        $this->teamService = $teamService;
    }

    /**
     * Retrieve all injuries RFD created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/injuries/rfd/list/user",
     *  tags={"Injury/RFD"},
     *  summary="List all injuries rfd create by user authenticate
     *  - Lista todos los programas RFD de lesiones creado por el usuario",
     *  operationId="list-injuries-rfd-user",
     *  description="List all injuries rfd create by user authenticate -
     *  Lista todos los programas RFD de lesiones creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
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
    public function getAllInjuriesRfdUser()
    {
        $rfds = $this->rfdService->allInjuriesRfdByUser(Auth::id());

        return $this->sendResponse($rfds, 'List all injuries rfd of user');
    }


    /**
     * Display a listing of criteria.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries",
     *  tags={"Injury/RFD"},
     *  summary="Get list Rfd - Lista de RFD",
     *  operationId="list-injury-rfd",
     *  description="Return data list  RFD  - Retorna listado de RFD",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function index()
    {
        $rfds = $this->rfdRepository->findAll();
        
        return $this->sendResponse($rfds, 'List of Injuries Rfd');
    }

    /**
     * Display a listing of criteria.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/team/{team_id}",
     *  tags={"Team/Injuries/RFD"},
     *  summary="List of players with RFD",
     *  operationId="list-injury-rfd",
     *  description="Return data list  RFD  - Retorna listado de RFD",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function teamIndex(Team $team)
    {
        try {
            $rfds = $this->teamService->listTeamRDFInjuries($team);
            return $this->sendResponse($rfds, 'Team players RFDs records');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing team RFDS', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/injuries",
     *       tags={"Injury/RFD"},
     *       summary="Stored Rfd - guardar un nuevo Rfd ",
     *       operationId="injury-rfd-store",
     *       description="Store a new Rfd - Guarda un  nuevo Rfd",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/StoreInjuryRfdRequest")
     *         )
     *       ),
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
     * Store a newly created resource in storage.
     * @param StoreInjuryRfdRequest $request
     * @return Response
     */
    public function store(StoreInjuryRfdRequest $request)
    {
        $permission = Gate ::inspect('store-injury-rfd', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $situation = $this->situationRepository->findOneBy(["code" => "cant_passed"]);
            
            $request['percentage_complete'] = 0;
            $request['current_situation_id'] =  $situation->id;
            $request['closed'] = false;
            $request['user_id'] = Auth::id();

            $rfd = $this->rfdRepository->create($request->all());

            $phases = $this->rfdService->createPhases($rfd->id);

            if (!$phases['success']) {
                return $this->sendError('Error by Create Phases Detail', $phases['message']);
            }

            $criteria = $this->rfdService->createCriteria($rfd->id);

            if (!$criteria['success']) {
                return $this->sendError('Error by Create Criteria', $criteria['message']);
            }

            $rfd['phasesCreate'] = $phases['data'];
            $rfd['criteriaCreate'] = $criteria['data'];

            return $this->sendResponse($rfd,  $this->translator('rfd_created'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Rfd', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *       path="/api/v1/injuries/{code}",
     *       tags={"Injury/RFD"},
     *       summary="Show Rfd - Ver los datos de un Rfd",
     *       operationId="show-injury-rfd",
     *       description="Return data to Rfd  - Retorna los datos de un Rfd",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Parameter( ref="#/components/parameters/team_query_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code, ShowInjuryRfdRequest $request)
    {
        try {
            $rfd = $this->rfdRepository->findOneBy(["code" => $code]);

            if (!$rfd) {
                return $this->sendError("Error", "RFD not found", Response::HTTP_NOT_FOUND);
            }

            $permission = Gate::inspect('read-injury-rfd', $request->team_id);

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }

            $rfd = $this->rfdRepository->getRfdAll($rfd->id);

            return $this->sendResponse($rfd, 'RFD information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving rfd ', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/{code}/advance",
     *       tags={"Injury/RFD"},
     *       summary="Get Rfd Advance - Ver el avance de un Rfd",
     *       operationId="advance-injury-rfd",
     *       description="Return data to Rfd Advance - Retorna los datos del Avance del Rfd ",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function getAdvance($code)
    {
        try {

            $rfd = $this->rfdRepository->findOneBy(["code" => $code]);

            if (!$rfd) {
                return $this->sendError("Error", "rfd not found", Response::HTTP_NOT_FOUND);
            }

            $rfd = $this->rfdRepository->getrfdAdvance($rfd->id);

            return $this->sendResponse($rfd, 'rfd Advance information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving rfd Advance ', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/players/injuries/{team_id}",
     *       tags={"Injury/RFD"},
     *       summary="List of Players with Rfd by team  -Listado de jugadores con Rfd por equipo",
     *       operationId="list-injury-players",
     *       description="Return data to List of Players with Rfd - Retorna el listado de jugadores con Rfd ",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Parameter( ref="#/components/parameters/search" ),
     *       @OA\Parameter( ref="#/components/parameters/order" ),
     *       @OA\Parameter( ref="#/components/parameters/filter" ),
     *       @OA\Parameter( ref="#/components/parameters/value" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a listing of players.
     * @param Request $request
     * @return Response
     */
    public function listOfPlayersByRfd(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-injury-rfd', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $filter = $request->filter ? $this->rfdService->getFilterList($request->filter, $request->value) : null;

        $players = $this->rfdRepository->listOfPlayersByRfd($teamId, $request->search, $request->order, $filter);
 
        return $this->sendResponse($players, 'List of Players by rfd');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/players/{player_id}/rfds",
     *       tags={"Injury/RFD"},
     *       summary="Get Abstract by player rfds - Ver el resumen de las RFDs del jugador",
     *       operationId="abstract-injury-player",
     *       description="Return data to Abstract by player rfds
     *       - Retorna los datos del resumen  de las RFDs del jugador ",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display player historic of RFDs.
     * @return Response
     */
    public function rfdHistoricByPlayer($player_id)
    {
        $player = $this->playerRepository->find($player_id);

        if (!$player) {
            return $this->sendError("Error", "Player not found", Response::HTTP_NOT_FOUND);
        }

        $playerResume = $this->rfdService->rfdHistoricByPlayer($player_id);

        if (!$playerResume['success']) {
            return $this->sendError('Error by retrieving Player Abstract', $playerResume['message']);
        }

        return $this->sendResponse($playerResume['data'], 'Historic of RFDs by player');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/players/{player_id}/injuries",
     *       tags={"Injury/RFD"},
     *       summary="Get Abstract by player injuries - Ver el resumen de las lesiones del jugador",
     *       operationId="abstract-injury-player",
     *       description="Return data to Abstract by player injuries
     *       - Retorna los datos del resumen  de las lesiones del jugador ",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display player resume.
     * @return Response
     */
    public function rfdAbstractByPlayer($player_id)
    {
        $player = $this->playerRepository->find($player_id);

        if (!$player) {
            return $this->sendError("Error", "Player not found", Response::HTTP_NOT_FOUND);
        }

        $playerResume = $this->rfdService->rfdAbstractByPlayer($player_id);

        if (!$playerResume['success']) {
            return $this->sendError('Error by retrieving Player Abstract', $playerResume['message']);
        }

        return $this->sendResponse($playerResume['data'], 'Abstract By Player RFD');
    }

    /**
     * @OA\Put(
     *       path="/api/v1/injuries/{code}",
     *       tags={"Injury/RFD"},
     *       summary="Edit Rfd - Editar un Rfd",
     *       operationId="injury-rfd-edit",
     *       description="Edit a Rfd - Edita un Rfd",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/UpdateInjuryRfdRequest")
     *         )
     *       ),
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
     * @param UpdateInjuryRfdRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateInjuryRfdRequest $request, $code)
    {
        $permission = Gate::inspect('update-injury-rfd', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $rfd = $this->rfdRepository->findOneBy(["code" => $code]);

            if (!$rfd) {
                return $this->sendError("Error", "rfd not found", Response::HTTP_NOT_FOUND);
            }

            $updated = $this->rfdRepository->update($request->all(), $rfd);

            $this->rfdService->updatedCriterias($request->criterias, $rfd->id);

            return $this->sendResponse($updated, 'rfd data updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating rfd', $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *       path="/api/v1/injuries/closed/{code}",
     *       tags={"Injury/RFD"},
     *       summary="Closed Rfd - Cerrar un Rfd",
     *       operationId="injury-rfd-closed",
     *       description="Closed a Rfd - Cierra un Rfd",
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
     * Closed RFD
     * @param int $code
     * @return Response
     */
    public function closed($code)
    {
        try {

            $rfd = $this->rfdRepository->findOneBy(["code" => $code]);

            if (!$rfd) {
                return $this->sendError("Error", "rfd not found", Response::HTTP_NOT_FOUND);
            }

            $closed = $this->rfdService->closedRfd($rfd->id);

            if (!$closed['success']) {
                return $this->sendError('Error by closed Rfd', $closed['message']);
            }

            return $this->sendResponse($closed['data'], 'Rfd closed');
        } catch (Exception $exception) {
            return $this->sendError('Error by closed rfd', $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *       path="/api/v1/injuries/{code}",
     *       tags={"Injury/RFD"},
     *       summary="Delete Rfd- Elimina un Rfd",
     *       operationId="injury-rfd-delete",
     *       description="Delete a Rfd - Elimina un Rfd",
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
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     */
    public function destroy(DeleteInjuryRfdRequest $request, $code)
    {
        try {
            $rfd = $this->rfdRepository->findOneBy(["code" => $code]);

            if (!$rfd) {
                return $this->sendError("Error", "rfd not found", Response::HTTP_NOT_FOUND);
            }

            $permission = Gate::inspect('delete-injury-rfd', $request->team_id);

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }

            return $this->rfdRepository->delete($rfd->id)
                ? $this->sendResponse(null, 'rfd deleted', Response::HTTP_ACCEPTED)
                : $this->sendError('rfd Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting rfd', $exception->getMessage());
        }
    }
}
