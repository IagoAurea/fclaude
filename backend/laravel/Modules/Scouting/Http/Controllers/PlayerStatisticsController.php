<?php

namespace Modules\Scouting\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Player\Entities\Player;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\EffortRecovery\Services\EffortRecoveryService;
use Modules\Scouting\Services\Interfaces\PlayerStatisticServiceInterface;

class PlayerStatisticsController extends BaseController
{
    /**
     * @var $playerStatisticService
     */
    protected $playerStatisticService;
    
    /**
     * @var $effortRecoveryService
     */
    protected $effortRecoveryService;

    public function __construct(
        PlayerStatisticServiceInterface $playerStatisticService,
        EffortRecoveryService $effortRecoveryService
    )
    {
        $this->playerStatisticService = $playerStatisticService;
        $this->effortRecoveryService = $effortRecoveryService;
    }

    /**
     *  Retrieves statistcis of a specific player in a given competition
     *  @param Int $player_id
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/players/{player_id}/statistics",
     *      tags={"Player"},
     *      summary="Show Player Statistics competitions of player -
     *      Mostrar estadisticas de competiciones de un jugador",
     *      operationId="player-statistic-by-player",
     *      description="Show Player Statistics competitions of player -
     *      Mostrar estadisticas de competiciones de un jugador",
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
    public function getStatisticsByPlayer(Player $player)
    {
        try {
            $result = $this->playerStatisticService->ByPlayer($player);

            return $this->sendResponse($result, sprintf('Statistics for player %s', $player->id));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError($exception->getTrace(), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while fetching the statistics', $exception->getMessage());
        }
    }

    /**
     *  Retrieves statistcis of a specific player in a given competition
     *  @param Int $competition_id
     *  @param Int $player_id
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/scouting/competition/{competition_id}/player/{player_id}/resume",
     *      tags={"Player"},
     *      summary="Show Player Statistic in a competition - Mostrar estadisticas de un jugador en una competition",
     *      operationId="player-statistic-by-competition",
     *      description="Show Player Statistic in a competition -
     *      Mostrar estadisticas de un jugador en una competition",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/competition_id" ),
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
    public function getStatisticsOfPlayersByCompetition($competition_id, $player_id)
    {
        try {
            $result = $this
                ->playerStatisticService
                ->ByCompetition($competition_id, $player_id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError($exception->getTrace(), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while fetching the statistics',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse($result,
            sprintf('Statistics for player %s in competition %s', $player_id, $competition_id));
    }
}
