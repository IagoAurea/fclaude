<?php

namespace Modules\Nutrition\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Repositories\Interfaces\NutritionRepositoryInterface;

class NutritionController extends BaseController
{
    /**
     * @var $nutritionRepository
     */
    protected $nutritionRepository;

    public function __construct(NutritionRepositoryInterface $nutritionRepository)
    {
        $this->nutritionRepository = $nutritionRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/team/{team_id}",
    *       tags={"Nutrition"},
    *       summary="Get list players nutrition by team - Lista de jugadores con nutrición por equipo",
    *       operationId="list-nutrition",
    *       description="Return data players nutrition -
    *       Retorna listado de jugadores con detalle de nutrición por equipo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/team_id" ),
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
     * Display a listing of the Nutritional Sheet with the player .
     * @return json
     */
    public function index(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-nutrition', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $lisOfPlayer = $this->nutritionRepository->findAllPlayersDetail($teamId);
        
        return $this->sendResponse($lisOfPlayer, 'List  Player - Nutritional Sheet');
    }
}
