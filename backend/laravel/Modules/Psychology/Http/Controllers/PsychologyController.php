<?php

namespace Modules\Psychology\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Rest\BaseController;
use Modules\Psychology\Services\PsychologyService;

class PsychologyController extends BaseController
{
    /**
     * Player service
     * @var $psychologyService
     */
    protected $psychologyService;

    /**
     * PsychologyController constructor.
     * @param PsychologyService $psychologyService
     */
    public function __construct(PsychologyService $psychologyService)
    {
        $this->psychologyService = $psychologyService;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/players/{team_id}/psychology",
     *      tags={"Player"},
     *      summary="Player Psychology List - Listado de Jugadores con Psicologia",
     *      operationId="player-index",
     *      description="Shows a list of players with psychology depending on the team - Muestra el listado de jugadores con psicología de un equipo",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/team_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    /**
     * Get players with psychology data
     * @param Request $request
     * @param $team_id
     * @return JsonResponse
     */
    public function playersWithPsychologyDataByTeam(Request $request, $team_id)
    {
        $permission = Gate::inspect('list-psychology', $team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $filters = new \stdClass();
        $filters->type = $request->type;
        $filters->value = $request->value;

        $players = $this->psychologyService->getPlayersWithPsychologyByTeam($filters, $team_id);

        return $this->sendResponse($players, 'List Player with phycology');
    }
}
