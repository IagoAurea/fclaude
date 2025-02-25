<?php

namespace Modules\Player\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Rest\BaseController;
use Modules\Player\Services\LineupPlayerTypeService;
use Modules\Player\Http\Requests\SportFilterRequest;

class LineupPlayerTypeController extends BaseController
{
    /**
     * @var object $lineupPlayerTypeService
     */
    protected $lineupPlayerTypeService;

    /**
     * Creates a new controller instance
     */
    public function __construct(LineupPlayerTypeService $lineupPlayerTypeService)
    {
        $this->lineupPlayerTypeService = $lineupPlayerTypeService;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/players/type-players",
     *      tags={"Player"},
     *      summary="List lineup player types by sport - Listado de tipo de lineamiento de Jugadores por deporte",
     *      operationId="player-lineup-index",
     *      description="Shows a list of lineup player type by sport - Muestra el listado de tipo de lieamiento de jugadores por deporte",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ), 
     *      @OA\Parameter( ref="#/components/parameters/sports" ), 
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
     * 
     * Get all lineup player types
     * @return JsonResponse
     */
    public function index(SportFilterRequest $request)
    {
        return $this->sendResponse($this->lineupPlayerTypeService->getLineupPlayerType($request->sport), 'List Lineup Player Types');
    }
}
