<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreExerciseSessionAssistenceRequest;
use Modules\Training\Repositories\Interfaces\ExerciseSessionRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionAssistanceRepositoryInterface;

class ExerciseSessionAssistanceController extends BaseController
{
    /**
     * @var $assistanceRepository
     */
    protected $assistanceRepository;

    /**
     * @var object $exerciseSessionRepository
     */
    protected $exerciseSessionRepository;


    public function __construct(
        ExerciseSessionAssistanceRepositoryInterface $assistanceRepository,
        ExerciseSessionRepositoryInterface $exerciseSessionRepository
    )
    {
        $this->assistanceRepository = $assistanceRepository;
        $this->exerciseSessionRepository = $exerciseSessionRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/assistance/exercise-sessions/{exercise_session_code}/{academic_year_id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list assistance by session profile teacher - Lista de asistencia a una session para perfil profesor",
    *       operationId="list-assistance-academic-year",
    *       description="Return data assistence to session profile teacher - Retorna listado de asistenca a una sesión perfil profesor",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_code" ),
    *       @OA\Parameter( ref="#/components/parameters/academic_year_id" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    * @OA\Get(
    *       path="/api/v1/training/assistance/exercise-sessions/{exercise_session_code}",
    *       tags={"ExerciseSession"},
    *       summary="Get list assistance by session - Lista de asistencia a una session",
    *       operationId="list-assistance",
    *       description="Return data assistence to session  - Retorna listado de asistenca a una sesión",
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
     * Display a listing of the resource.
     * @param int $session_code
     * @return Response
     */
    public function index($session_code, $academic_year_id = null)
    {
        $listOfAssistances = $this->exerciseSessionRepository->findAllAssistancesBySession(
            $session_code, $academic_year_id
        );

        return $this->sendResponse($listOfAssistances, 'List of assistances by session');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/assistance/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Stored Assistence - guardar una nueva asistencia ",
    *       operationId="assistance-store",
    *       description="Store a new assistance - Guarda una nueva asistencia",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreExerciseSessionAssistenceRequest")
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
     * Store Assistance to Session.
     * @param StoreExerciseSessionAssistenceRequest $request
     * @return Response
     */
    public function store(StoreExerciseSessionAssistenceRequest $request)
    {
        try {
            $assistanceData = $this->assistanceRepository->createAssistanceToExerciseSession($request);

            return $this->sendResponse($assistanceData,
                trans('training::messages.exercise_session_assistance_store'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Assistance', $exception->getMessage());
        }
    }

}
