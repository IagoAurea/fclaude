<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreExerciseSessionDetailRequest;
use Modules\Training\Repositories\Interfaces\ExerciseSessionDetailRepositoryInterface;

class ExerciseSessionDetailController extends BaseController
{
    /**
     * @var $sessionDetailRepository
     */
    protected $sessionDetailRepository;

    public function __construct(
        ExerciseSessionDetailRepositoryInterface $sessionDetailRepository
    )
    {
        $this->sessionDetailRepository = $sessionDetailRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/executions/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Get list executions  - Lista de ejecuciones",
    *       operationId="list-execution",
    *       description="Return data executions   - Retorna listado de ejecuciones",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
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
     * @return Response
     */
    public function index()
    {
        $sessionDetail = $this->sessionDetailRepository->findAll();

        return $this->sendResponse($sessionDetail, 'List of Exercise Sessions Executions');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/executions/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Stored execution - guardar una nueva ejecución de la sesión ",
    *       operationId="execution-store",
    *       description="Store a new execution - Guarda una nueva ejecución",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreExerciseSessionDetailRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Store a new Exercise Session.
     * @param StoreExerciseSessionDetailRequest $request
     * @return Response
     */
    public function store(StoreExerciseSessionDetailRequest $request)
    {
        try {
            $sessionDetail = $this->sessionDetailRepository->create($request->all());

            return $this->sendResponse($sessionDetail, 'Execution stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Execution', $exception->getMessage());
        }
    }

    
    /**
    * @OA\Get(
    *       path="/api/v1/training/executions/exercise-sessions/{exercise_session_code}",
    *       tags={"ExerciseSession"},
    *       summary="Get list executions by session - Lista de ejecuciones de una sesión",
    *       operationId="list-executions-session",
    *       description="Return data executions to session  - Retorna listado de ejecución de una sesión",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_code" ),
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
     * Display a listing of Executions by session.
     * @param int $session_code
     * @return Response
     */
    public function lisBySession($session_code)
    {
        $sessionDetail = $this->sessionDetailRepository->findAllBySessionCode($session_code);

        return $this->sendResponse($sessionDetail, 'List of Exercise Sessions Executions By Session');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/executions/exercise-sessions/team/{team_id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list executions by session - Lista de ejecuciones de  sesión por equipo",
    *       operationId="list-executions-team",
    *       description="Return data assistence to session  - Retorna listado de asistenca de sesión por equipo",
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
     * Display a listing of Executions by session.
     * @param int $team_id
     * @return Response
     */
    public function lisByTeam($team_id)
    {
        $sessionDetail = $this->sessionDetailRepository->findAllByTeamId($team_id);

        return $this->sendResponse($sessionDetail, 'List of Exercise Sessions Executions By Team');
    }
}
