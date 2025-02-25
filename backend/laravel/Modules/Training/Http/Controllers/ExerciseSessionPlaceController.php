<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Club\Entities\Club;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Repositories\Interfaces\ExerciseSessionPlaceRepositoryInterface;

class ExerciseSessionPlaceController extends BaseController
{
    /**
     * @var $sessionPlaceRepository
     */
    protected $sessionPlaceRepository;


    public function __construct(
        ExerciseSessionPlaceRepositoryInterface $sessionPlaceRepository
    )
    {
        $this->sessionPlaceRepository = $sessionPlaceRepository;
    }
    /**
    * @OA\Get(
    *       path="/api/v1/training/exercise-sessions/{club_id}/places",
    *       tags={"ExerciseSession"},
    *       summary="Get list places for exercise session - Lista de lugares para sesiones de ejercicios",
    *       operationId="list-exercise-session-place",
    *       description="Return data place exercise session -
    *       Retorna listado de lugares para sesiones de ejercicios",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/club_id" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Club $club)
    {
        try {
            $sessionPlaces = $this->sessionPlaceRepository->findBy([
                'entity_id' => $club->id,
                'entity_type' => get_class($club)
            ]);

            return $this->sendResponse($sessionPlaces, 'List places club');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating order exercises to exercise eession', $exception->getMessage());
        }
    }

}
