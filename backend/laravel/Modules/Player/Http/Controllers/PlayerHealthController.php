<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Modules\Health\Services\HealthService;
use Modules\Health\Services\SurgeryService;
use App\Http\Controllers\Rest\BaseController;

// Requests
use Modules\Player\Http\Requests\HealthStatusRequest;

// Entities
use Modules\Player\Entities\Player;

class PlayerHealthController extends BaseController
{
    /**
     * @var array
     */
    const EXCEPTING_VALUES = [
        '_lang',
        'surgeries',
    ];

    /**
     * @var object
     */
    protected $healthService;

    /**
     * @var object
     */
    protected $surgeryService;

    /**
     * Instance a controller class
     */
    public function __construct(
        HealthService $healthService,
        SurgeryService $surgeryService
    ) {
        $this->healthService = $healthService;
        $this->surgeryService = $surgeryService;
    }

    /**
     *  Retrieves full information of a specific player
     *  @param Int $id
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/players/{player_id}/health",
     *      tags={"Player"},
     *      summary="Show Player Health- Mostrar Salud del Jugador",
     *      operationId="player-health-show",
     *      description="Shows player's health information - Muestra informacion de jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * Gets the current health status of the player
     *
     * @param Integer $id
     * @return Response
     */
    public function viewHealthStatus(Player $player)
    {
        $player_health_status = [
            'diseases' => $player->diseases,
            'allergies' => $player->allergies,
            'body_areas' => $player->bodyAreas,
            'physical_problems' => $player->physicalProblems,
            'medicine_types' => $player->medicineTypes,
            'tobacco_consumptions' => $player->tobaccoConsumptions[0] ?? NULL,
            'alcohol_consumptions' => $player->alcoholConsumptions[0] ?? NULL,
            'surgeries' => $player->surgeries,
        ];

        return $this->sendResponse($player_health_status, 'Player Health Information');
    }

    /**
     *
     * @OA\Post(
     *      path="/api/v1/players/{player_id}/health",
     *      tags={"Player"},
     *      summary="Update Player Health- Actualiza la salud del Jugador",
     *      operationId="player-health-update",
     *      description="Update player's health information - Actualiza informacion de la salud del jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/HealthStatusRequest")
     *        )
     *      ),
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
     * Manages all player's health relationships
     * @param HealthStatusRequest
     * @return Response
     */
    public function manageHealthStatus(HealthStatusRequest $request, Player $player)
    {
        try {
            $health_items = $request->except(self::EXCEPTING_VALUES);

            $this->healthService->updateHealthStatus($player, $health_items);

            $this->surgeryService->manageSurgeries($player, $request->surgeries);

            return $this->sendResponse(NULL, 'Player Health Status Updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating player health status', $exception->getMessage());
        }
    }
}
