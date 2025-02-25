<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Services\TrainingLoadService;

class TrainingLoadController extends BaseController
{
    /**
     * @var $trainingLoadService
     */
    protected $trainingLoadService;


    public function __construct(
        TrainingLoadService $trainingLoadService
    )
    {
        $this->trainingLoadService = $trainingLoadService;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/training/training-load-period/{entity}/{id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list training load group period by entity (player/alumn)
    *       - Lista la carga de entrenamiento agrupado por periodo por entidad (jugador/alumno) ",
    *       operationId="list-training-load-period-entity",
    *       description="Return data list training load group by entity (player/alumn)
    *       - Retorna Lista la carga de entrenamiento agrupado por periodo por entidad (jugador/alumno)",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/entity" ),
    *       @OA\Parameter( ref="#/components/parameters/id_path" ),
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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function indexPeriodByEntity($entity, $id)
    {
        try {
            $training_loads = $this->trainingLoadService->trainingLoadsByPeriodAndEntity($entity, $id);

            return $this->sendResponse($training_loads, 'List training load group by period');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing training load', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/training-load/{entity}/{id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list training load by entity (player/alumn)
    *       - Lista la carga de entrenamiento por entidad (jugador/alumno) ",
    *       operationId="list-training-load-entity",
    *       description="Return data list training load by entity (player/alumn)
    *       - Retorna Lista la carga de entrenamiento por entidad (jugador/alumno)",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/entity" ),
    *       @OA\Parameter( ref="#/components/parameters/id_path" ),
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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function indexByEntity($entity, $id)
    {
        try {
            $training_loads = $this->trainingLoadService->trainingLoadByEntity($entity, $id);

            return $this->sendResponse($training_loads, 'List training load');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing training load', $exception->getMessage());
        }
    }

}
