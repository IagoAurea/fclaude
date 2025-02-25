<?php

namespace Modules\InjuryPrevention\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Modules\Player\Entities\Player;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Rest\BaseController;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\InjuryPrevention\Services\InjuryPreventionService;
use Modules\InjuryPrevention\Http\Requests\CreateInjuryPrevention;
use Modules\InjuryPrevention\Http\Requests\UpdateInjuryPrevention;

class InjuryPreventionController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object $injuryPreventionService
     */
    protected $injuryPreventionService;

    /**
     * Creates a new controller instance
     */
    public function __construct(InjuryPreventionService $injuryPreventionService)
    {
        $this->injuryPreventionService = $injuryPreventionService;
    }

    /**
     * Retrieve all injuries prevention created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/injury-prevention/list/user",
     *  tags={"InjuryPrevention"},
     *  summary="List all injuries prevention of user authenticate
     *  - Lista todos las programas de prevenciones creado por el usuario",
     *  operationId="list-injury-prevention-user",
     *  description="List all injuries prevention of user authenticate -
     *  Lista todos las programas de prevenciones creado por el usuario",
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
    public function getAllInjuriesPreventionUser()
    {
        $injuriesPrevention = $this->injuryPreventionService->allInjuriesPreventionByUser(Auth::id());

        return $this->sendResponse($injuriesPrevention, 'List all injuries preventions of user');
    }

    /**
     * Retrieves a listing of all players with injury prevention items
     * @return Response
     * 
     * @OA\Get(
     *   path="/api/v1/injury-prevention/{team_id}/players",
     *   tags={"InjuryPrevention"},
     *   summary="Retrieves all team's players with their related injury prevention programs",
     *   operationId="list-injury-prevention-players",
     *   description="Returns a list of all players",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a listing of all injury prevention items related to a player",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/InjuryPreventionPlayerListResponse"
     *      )
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function players(Request $request, Team $team)
    {
        $permission = Gate::inspect('list-injury-prevention', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $players = $this->injuryPreventionService->getPlayersList2($request->all(), $team->id);

        return $this->sendResponse($players, 'List of Injury Prevention Players');
    }

    /**
     * Retrieves a listing of all players with injury prevention related to a player
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Retrieves all injury programs related to a specific player",
     *  operationId="list-injury-prevention--player-items",
     *  description="Returns a list of injury prevention programs related to a player",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a listing of all injury prevention items related to a player",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/InjuryPreventionListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Team $team, Player $player)
    {
        if ($player->team_id != $team->id) {
            abort(Response::HTTP_FORBIDDEN, $this->translator('user_forbidden'));
        }

        $injuryPreventions = $this->injuryPreventionService->injuryPreventionList($player);

        return $this->sendResponse($injuryPreventions, 'List of Player Injury Preventions');
    }

    /**
     * Stores a new Injury Prevention item
     *
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Creates a Injury Prevention item - Crea un item de Prevencion de Lesion",
     *  operationId="store-injury-prevention",
     *  description="Creates a Injury Prevention item - Crea un item de Prevencion de Lesion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CreateInjuryPreventionRequest"
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
    public function store(CreateInjuryPrevention $request, Team $team, Player $player)
    {
        $permission = Gate::inspect('store-injury-prevention', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $request['user_id'] = Auth::id();

        try {
            $injuryPrevention = $this->injuryPreventionService->store($request->all(), $player->id);

            return $this->sendResponse($injuryPrevention, 'Injury Prevention Stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by inserting daily work', $exception->getMessage());
        }
    }

    /**
     * Retrieves specific data of an injury prevention
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}/show/{injury_prevention_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Retrieves specific information of an injury prevention program",
     *  operationId="show-injury-prevention",
     *  description="Retrieves information about injury prevention program",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/injury_prevention_id"
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
    public function show(Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        $permission = Gate::inspect('read-injury-prevention', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $injury =  $this->injuryPreventionService->find($injuryPrevention, $team->id);

            return $this->sendResponse($injury, 'Injury Prevention Information');
        } catch (Exception $exception) {
            return $this->sendError(
                $exception->getMessage() ?? 'Error by retrieving injury prevention',
                null,
                $exception->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Updates an existent Injury Prevention item
     *
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}/show/{injury_prevention_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Creates a Injury Prevention item - Crea un item de Prevencion de Lesion",
     *  operationId="update-injury-prevention",
     *  description="Creates a Injury Prevention item - Crea un item de Prevencion de Lesion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/injury_prevention_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateInjuryPreventionRequest"
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
    public function update(UpdateInjuryPrevention $request, Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        $permission = Gate::inspect('update-injury-prevention', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $injury = $this->injuryPreventionService->update(
                $request->all(),
                $injuryPrevention
            );

            return $this->sendResponse($injury, 'Injury prevention successfully updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating injury prevention', $exception->getMessage());
        }
    }

    /**
     * Deletes an injury prevention program
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}/delete/{injury_prevention_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Deletes a player injury prevention item from database",
     *  operationId="delete-injury-prevention",
     *  description="Deletes an injury prevention item from the database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/injury_prevention_id"
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
    public function destroy(Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        $permission = Gate::inspect('delete-injury-prevention', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $this->injuryPreventionService->destroy($injuryPrevention->id);

            return $this->sendResponse(null, 'Injury prevention successfully deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting injury prevention', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injury-prevention/{team_id}/players/{player_id}/pdf/{injury_prevention_id}",
     *       tags={"InjuryPrevention"},
     *       summary="Get InjuryPrevention PDF - Obtener PDF de una prevención de lesión",
     *       operationId="pdf-injury-prevention",
     *       description="Retrieves information about injury prevention program",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter(
     *          ref="#/components/parameters/team_id"
     *       ),
     *       @OA\Parameter(
     *           ref="#/components/parameters/player_id"
     *       ),
     *       @OA\Parameter(
     *           ref="#/components/parameters/injury_prevention_id"
     *       ),
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
     * Generate PDF
     *
     * @param $id
     * @return JsonResponse
     */
    public function generatePdf(Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        try {

            $data =  $this->injuryPreventionService->find($injuryPrevention);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('injuryprevention::injury-prevention', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('injury-prevention-%s.pdf', $injuryPrevention->id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Injury Prevention', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injury-prevention/{team_id}/players/{player_id}/pdfs",
     *       tags={"InjuryPrevention"},
     *       summary="Get InjuryPrevention PDFs - Obtener PDFs de todas las prevenciones de lesión de un jugador",
     *       operationId="pdfs-injury-prevention",
     *       description="Retrieves information about injury prevention program",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter(
     *          ref="#/components/parameters/team_id"
     *       ),
     *       @OA\Parameter(
     *           ref="#/components/parameters/player_id"
     *       ),
     *       @OA\Parameter(
     *           ref="#/components/parameters/injury_prevention_id"
     *       ),
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
     * Generate PDF
     *
     * @param $id
     * @return JsonResponse
     */
    public function generatePdfs(Team $team, Player $player)
    {
        try {

            $data =  $this->injuryPreventionService->injuryPreventionList($player);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('injuryprevention::injury-preventions', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('injury-prevention-%s.pdf', $player->id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Injury Prevention', $exception->getMessage());
        }
    }
}
