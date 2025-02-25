<?php

namespace Modules\EffortRecovery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\EffortRecovery\Services\StrategyService;
use Exception;

class EffortRecoveryStrategyController extends BaseController
{
    /**
     * @var $strategyService
     */
    protected $strategyService;

    /**
     * Creates a new controller instance
     */
    public function __construct(StrategyService $strategyService)
    {
        $this->strategyService = $strategyService;
    }

    /**
     * Lists all possible strategies related to an effort recovery program
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/strategies",
     *  tags={"EffortRecovery"},
     *  summary="Effort Recovery Program Strategy Index Endpoint - Endpoint de Listado de Estrategias para programas de Recuperacion del Esfuerzos",
     *  operationId="list-effort-recovery-strategies",
     *  description="Returns a list of all recovery effort items related to a player
     *  Obtiene un listado de los programas de recupracion del esfuerzo relacionados con un jugador",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
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
    public function index ()
    {
        try {
            $strategies = $this->strategyService->list();
            return $this->sendResponse($strategies, 'List of Effort Recovery Strategies');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing strategies', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
