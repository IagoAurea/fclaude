<?php

namespace Modules\EffortRecovery\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Modules\Player\Entities\Player;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Modules\EffortRecovery\Services\EffortRecoveryService;
use Modules\EffortRecovery\Http\Requests\StoreEffortRecoveryRequest;

class EffortRecoveryController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $questionnaireService
     */
    protected $effortService;

    /**
     * Creates a new controller instance
     */
    public function __construct(EffortRecoveryService $effortService)
    {
        $this->effortService = $effortService;
    }

    /**
     * Retrieve all injuries RFD created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/list/user",
     *  tags={"EffortRecovery"},
     *  summary="List all efforts recovery create by user authenticate
     *  - Lista todos las recuperaciones del esfuerzo creado por el usuario",
     *  operationId="list-effort-recovery-user",
     *  description="List all efforts recovery create by user authenticate -
     *  Lista todos las recuperaciones del esfuerzo creado por el usuario",
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
    public function getAllEffortRecoveryUser()
    {
        $efforts = $this->effortService->allEffortsRecoveryByUser(Auth::id());

        return $this->sendResponse($efforts, 'List all efforts recovery of user');
    }

    /**
     * Retrieves a list of players depending on the team
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/{team_id}/players",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Players Index Endpoint -
     *  Endpoint de Listado de Jugadores de Programas de Recuperacion del Esfuerzos",
     *  operationId="list-effort-players-recovery",
     *  description="Returns a list of all players with or without one or more effort recovery programs
     *  Obtiene un listado de los jugadores de un equipo con o sin programas de recuperacion del esfuerzo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_name"
     *  ),
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
    public function listPlayers(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-effort-recovery', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $players = $this->effortService->listPlayers($teamId, $request->all());

            return $this->sendResponse($players, 'Effort Recovery Player List');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing effort recovery team players', $exception->getMessage());
        }
    }

    /**
     * Lists all recovery effort items of a related player
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/team/{team_id}/player/{player_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Program Index Endpoint -
     *  Endpoint de Listado de Programas de Recuperacion del Esfuerzos",
     *  operationId="list-effort-recovery",
     *  description="Returns a list of all recovery effort items related to a player
     *  Obtiene un listado de los programas de recupracion del esfuerzo relacionados con un jugador",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
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
    public function index($team, Player $player)
    {
        if ($team != $player->team_id) {
            abort(Response::HTTP_FORBIDDEN, $this->translator('user_forbidden'));
        }

        try {
            $efforts = $this->effortService->list($player);

            $result = [
                'player' => $player,
                'efforts' => $efforts
            ];

            return $this->sendResponse($result, 'Effort Recovery Program List');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by listing effort recovery programs',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Stores a new effort recovery program item into the database
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/effort-recovery/{player_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Program Store Endpoint -
     *  Endpoint de Creacion de Programa de Recuperacion del Esfuerzo",
     *  operationId="store-effort-recovery",
     *  description="Creates a Injury Prevention item - Crea un item de Prevencion de Lesion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreEffortRecoveryRequest"
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
    public function store(StoreEffortRecoveryRequest $request, Player $player)
    {
        $permission = Gate::inspect('store-effort-recovery', $player->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $request['user_id'] = Auth::id();

        try {
            $effort = $this->effortService->store($request->all(), $player);

            return $this->sendResponse($effort, $this->translator('effort_recovery_created'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by storing effort recovery item',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Returns an effort recovery program item
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/{player_id}/show/{effort_recovery_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Index Endpoint",
     *  operationId="show-effort-recovery",
     *  description="Returns specific data related to a effort recovery program item
     *  Obtiene datos relacionados con un programa de recuperacion del esfuerzo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
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
    public function show(Player $player, EffortRecovery $effortRecovery)
    {
        $permission = Gate::inspect('read-effort-recovery', $player->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $effort = $this->effortService->show($effortRecovery);
            return $this->sendResponse($effort, 'Effort Recovery Program');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving recovery item',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Stores a new effort recovery program item into the database
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/effort-recovery/{player_id}/update/{effort_recovery_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Program Update Endpoint -
     *  Endpoint de Actualizacion de Programa de Recuperacion del Esfuerzo",
     *  operationId="update-effort-recovery",
     *  description="Updates a Injury Prevention item - Actualiza un item de Prevencion de Lesion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreEffortRecoveryRequest"
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
    public function update(StoreEffortRecoveryRequest $request, Player $player, EffortRecovery $effortRecovery)
    {
        $permission = Gate::inspect('update-effort-recovery', $player->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $effort = $this->effortService->update($request->all(), $player, $effortRecovery);
            return $this->sendResponse($effort, $this->translator('effort_recovery_updated'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by storing effort recovery item',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Deletes an effort recovery program
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/effort-recovery/{player_id}/delete/{effort_recovery_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Delete Endpoint - Endpoint de Borrado de Programa de Recuperacion del Esfuerzo",
     *  operationId="delete-effort-recovery",
     *  description="Deletes an effort recovery program * Elimina un programa de recuperacion del esfuerzo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
     */
    public function destroy(Player $player, EffortRecovery $effortRecovery)
    {
        $permission = Gate::inspect('delete-effort-recovery', $player->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $result = $this->effortService->destroy($effortRecovery->id);
            return $this->sendResponse($result, $this->translator('effort_recovery_deleted'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving recovery item',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Returns an effort recovery program item
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/{player_id}/pdf/{effort_recovery_id}",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Index Endpoint",
     *  operationId="pdf-effort-recovery",
     *  description="Returns specific data related to a effort recovery program item as a PDF
     *  Obtiene datos relacionados con un programa de recuperacion del esfuerzo como un PDF",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
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
    public function generatePdf(Player $player, EffortRecovery $effortRecovery)
    {
        try {
            $data = $this->effortService->show($effortRecovery);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('effortrecovery::effort', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('effort-recovery-%s.pdf', $effortRecovery->id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving recovery item',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Lists all recovery effort items of a related player
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/{player_id}/pdfs",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Program Index Endpoint -
     *  Endpoint de Listado de Programas de Recuperacion del Esfuerzos",
     *  operationId="list-effort-recovery",
     *  description="Returns a list of all recovery effort items related to a player as a multiple PDF
     *  Obtiene un listado de los programas de recupracion del esfuerzo relacionados con un jugador como múltiples PDF",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
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
    public function generatePdfs(Player $player)
    {
        try {
            $data = $this->effortService->list($player);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('effortrecovery::efforts', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('effort-recovery-%s.pdf', $player->id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by listing effort recovery programs',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
