<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Rest\BaseController;
use Modules\Classroom\Entities\Classroom;
use Modules\Training\Entities\ExerciseSession;
use Modules\Training\Services\ExerciseSessionService;
use Modules\Training\Http\Requests\UpdateLikeRequest;
use Modules\Training\Http\Requests\UpdateOrderRequest;
use Modules\Training\Http\Requests\TestApplicationRequest;
use Modules\Training\Http\Requests\StoreExerciseSessionRequest;
use Modules\Training\Http\Requests\UpdateExerciseSessionRequest;
use Modules\Exercise\Repositories\Interfaces\LikeEntityRepositoryInterface;
use Modules\Training\Http\Requests\ShowTestApplicationRequest;

class ExerciseSessionController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $likeEntityRepository
     */
    protected $likeEntityRepository;

    /**
     * @var object $sessionService
     */
    protected $sessionService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        ExerciseSessionService $sessionService,
        LikeEntityRepositoryInterface $likeEntityRepository
    )
    {
        $this->sessionService = $sessionService;
        $this->likeEntityRepository = $likeEntityRepository;
    }

    /**
     * Retrieve all exercise sessions created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/all/classroom/user",
     *  tags={"Session Exercise"},
     *  summary="List all exercise sessions of classrooms by user authenticate
     *  - Lista todos las sesiones de ejercicios de las clases creado por el usuario",
     *  operationId="exercise-session-classroom-user",
     *  description="List all exercise sessions of classrooms by user authenticate -
     *  Lista todos las sesiones de ejercicios de las clases creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllExerciseSessionClassroomUser()
    {
        $matches = $this->sessionService->allExerciseSessionsByUser(Auth::id(), 'classroom');

        return $this->sendResponse($matches, 'List all exercise sessions classroom of user');
    }

    /**
     * Retrieve all exercise sessions created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/all/team/user",
     *  tags={"Session Exercise"},
     *  summary="List all exercise sessions of user authenticate
     *  - Lista todos las sesiones de ejercicios creado por el usuario",
     *  operationId="exercise-session-user",
     *  description="List all exercise sessions of user authenticate -
     *  Lista todos las sesiones de ejercicios creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllExerciseSessionTeamUser()
    {
        $matches = $this->sessionService->allExerciseSessionsByUser(Auth::id());

        return $this->sendResponse($matches, 'List all exercise sessions teams of user');
    }

    /**
     * Update order session exercise classroom
     *
     *  @OA\Put(
     *  path="/api/v1/training/exercise-sessions/classroom/{classroom_id}/order",
     *  tags={"Session Exercise"},
     *  summary="Update order session exercise classroom - Actualizar orden de las sesiones de ejercicio de clase",
     *  operationId="exercise-session-order-classroom",
     *  description="Returns update order session exercise classroom -
     *  Actualizar orden de las sesiones de ejercicio de clase",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/UpdateOrderRequest")
     *      )
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
    public function updateOrderSessionClassroom(Classroom $classroom, UpdateOrderRequest $request)
    {
        try {
            $update_order = $this->sessionService->updateOrderSessionExercise($request, $classroom);

            return $this->sendResponse($update_order, 'Update order session successfully');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating order session exercise', $exception->getMessage());
        }
    }

    /**
     * Update order session exercise
     *
     *  @OA\Put(
     *  path="/api/v1/training/exercise-sessions/team/{team_id}/order",
     *  tags={"Session Exercise"},
     *  summary="Update order session exercise team- Actualizar orden de las sesiones de ejercicio de equipo",
     *  operationId="exercise-session-order-team",
     *  description="Returns update order session exercise team -
     *  Actualizar orden de las sesiones de ejercicio de equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/UpdateOrderRequest")
     *      )
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
    public function updateOrderSessionTeam(Team $team, UpdateOrderRequest $request)
    {
        try {
            $update_order = $this->sessionService->updateOrderSessionExercise($request, $team);

            return $this->sendResponse($update_order, 'Update order session successfully');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating order session exercise', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of exercises by exercise sessions.
     *
     * @param $code
     * @param Classroom $classroom
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{code}/classroom/{classroom_id}/list-exercises",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="List exercise available exercise-sessions -
     *  Lista los ejercicios disponible para agregar sesión de ejercicio",
     *  operationId="list-exercises-exercise-sessions-classroom",
     *  description="Return list exercise available exercise-sessions  -
     *  Retorna lista los ejercicios disponible para agregar sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
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
    public function listExercisesClassroom($code, Classroom $classroom)
    {
        try {
            $exercises = $this->sessionService->listExercises($code, $classroom);

            return $this->sendResponse($exercises, 'List of Exercises for session classroom');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving list of exercises', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of exercises by exercise sessions.
     *
     * @param $code
     * @param Team $team
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{code}/team/{team_id}/list-exercises",
     *  tags={"Team/Exercise/Session"},
     *  summary="List exercise available exercise-sessions -
     *  Lista los ejercicios disponible para agregar sesión de ejercicio",
     *  operationId="list-exercises-exercise-sessions-team",
     *  description="Return list exercise available exercise-sessions  -
     *  Retorna lista los ejercicios disponible para agregar sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
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
    public function listExercisesTeam($code, Team $team)
    {
        try {
            $exercises = $this->sessionService->listExercises($code, $team);

            return $this->sendResponse($exercises, 'List of Exercises for session');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving list of exercises', $exception->getMessage());
        }
    }

    /**
     * Update Like exercise user
     *
     * @OA\Post(
     *  path="/api/v1/training/exercise-sessions/{exercise_session_id}/user/like",
     *  tags={"Session Exercise"},
     *  summary="Update like Session Exercise user - Actualizar like de sesion de ejercicio de usuario",
     *  operationId="exercise-like-users",
     *  description="Returns update like session exercise user - Actualizar like de sesion de ejercicio de usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/exercise_session_id"),
     *  @OA\RequestBody(
     *    @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="like", type="boolean"),
     *    )
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
    public function updateLike(UpdateLikeRequest $request, $id)
    {
        try {
            $entity = [
                'user_id' => Auth::id(),
                'entity_id' => $id,
                'entity_type' => ExerciseSession::class
            ];

            (bool)$request->like ?
                $this->likeEntityRepository->updateOrCreate($entity) :
                $this->likeEntityRepository->deleteByCriteria($entity);

            $message = (bool)$request->like ? 'like_session_exercise' : 'dislike_session_exercise';
            
            return $this->sendResponse(null, $this->translator($message));
        } catch (Exception $exception) {
            return $this->sendError('Error by update like', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of exercise sessions by search.
     *
     * @param Request $request
     * @param Team $team
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{team_id}",
     *  tags={"Team/Exercise/Session"},
     *  summary="Search exercise-sessions - Buscar una Sesión de ejercicio",
     *  operationId="list-exercise-sessions",
     *  description="Return data to exercise-sessions  - Retorna los datos de una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/order" ),
     *  @OA\Parameter( ref="#/components/parameters/search" ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all related team exercise sessions",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListExerciseSessionResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Request $request, Team $team)
    {
        $permission = Gate::inspect('list-training', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }
        try {
            $exerciseSessions = $this->sessionService->list($request->all(), $team);

            return $this->sendResponse($exerciseSessions, 'List of Exercise Session By Search');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving List of Exercise Session', $exception->getMessage());
        }
    }

    /**
     * Store a new Exercise Session.
     * @param StoreExerciseSessionRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/training/exercise-sessions/{team_id}",
     *  tags={"Team/Exercise/Session"},
     *  summary="Stores a new exercise session - Guardar una nueva sesión de ejercicio",
     *  operationId="exercise-sessions-store",
     *  description="Store a new exercise sessions - Guarda una nueva Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/StoreExerciseSessionRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Information about stored exercise session",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreExerciseSessionResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(StoreExerciseSessionRequest $request, Team $team)
    {
        $user = Auth::user();

        $permission = Gate::inspect('store-training', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $sessionData = $request->except(
                'exercises', 'execution', 'targets'
            );

            $sessionData['user_id'] = $user->id;

            $session = $this->sessionService->store(
                $team,
                $sessionData,
                $request->exercises,
                $request->execution,
                $request->targets,
                $user,
            );

            return $this->sendResponse(
                $session, trans('training::messages.exercise_session_store'), Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Exercise Sessions', $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{team_id}/show/{code}",
     *  tags={"Team/Exercise/Session"},
     *  summary="Show exercise-sessions - Ver los datos de una Sesión de ejercicio",
     *  operationId="show-exercise-sessions",
     *  description="Return data to exercise-sessions - Retorna los datos de una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Response(
     *      response=200,
     *      description="All related information about a single exercise session item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowExerciseSessionResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(Team $team, $code)
    {
        $permission = Gate::inspect('read-training', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $session = $this->sessionService->show($code);
            
            return $this->sendResponse($session, 'Exercise Session information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Exercise Session', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateExerciseSessionRequest $request
     * @param int $code
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/training/exercise-sessions/{team_id}/update/{code}",
     *  tags={"Team/Exercise/Session"},
     *  summary="Edit exercise-sessions - Editar una Sesión de ejercicio",
     *  operationId="exercise-sessions-edit",
     *  description="Edit a exercise-sessions - Edita una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/UpdateExerciseSessionRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Returns the result of updating exercise session item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateExerciseSessionResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateExerciseSessionRequest $request, Team $team, $code)
    {
        $permission = Gate::inspect('update-training', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $sessionData = $request->except('exercises', 'targets');

            $update = $this->sessionService->update(
                $team,
                $code,
                $sessionData,
                $request->execution,
                $request->targets,
                Auth::user()
            );

            return $this->sendResponse($update, trans('training::messages.exercise_session_update'));
        } catch (Exception $exception) {
            return $this->sendError('Error by Updating Exercise Session', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/training/exercise-sessions/{team_id}/delete/{code}",
     *  tags={"Team/Exercise/Session"},
     *  summary="Delete exercise-sessions - Elimina una Sesión de ejercicio",
     *  operationId="exercise-sessions-delete",
     *  description="Delete a exercise-sessions - Elimina una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Response(
     *      response=200,
     *      description="Returns the result of deleting exercise session item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteExerciseSessionResponse"
     *      )
     *  ),
     *   @OA\Response(
     *       response=422,
     *       ref="#/components/responses/unprocessableEntity"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function destroy(Team $team, $code)
    {
        $permission = Gate::inspect('delete-training', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $delete = $this->sessionService->delete(
                $team,
                $code,
                Auth::user()
            );
            
            return $this->sendResponse($delete, 'Exercise session deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting exercise session', $exception->getMessage());
        }
    }

    /**
     * Retrieve list materials exercise session
     * @param Team $team
     * @param string $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{team_id}/materials/{code}/list",
     *  tags={"Team/Exercise/Session"},
     *  summary="Show materials exercise sessions - Ver los materiales de una Sesión de ejercicio",
     *  operationId="list-materials-exercise-sessions",
     *  description="Return list materials to exercise-sessions - Retorna la lista de materials de una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
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
    public function listMaterials(Team $team, $code)
    {
        try {
            $list = $this->sessionService->listMaterials($team, $code);

            return $this->sendResponse($list, 'List materials exercise session information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving list materials exercise session', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/training/exercise-sessions/tests/sessions",
     *       tags={"ExerciseSession"},
     *       summary="Stored/Updated Test Application to exercise session -
     *       Guardar/Actualiza una Aplicación del test de una sesion de ejercicio",
     *       operationId="test-application-exercise-session",
     *       description="Stored or Updated Test Application to exercise session -
     *       Guardar/Actualiza una Aplicación del test a una sesion de ejercicio",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/TestApplicationExerciseSessionRequest")
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
     * Test application to Session Exercise
     *
     * @return Response
     */
    public function testApplication(TestApplicationRequest $request)
    {
        try {
            $application = $this->sessionService->testApplication($request);
            
            return $this->sendResponse($application['data'],
                trans(sprintf('training::messages.exercise_session_test_application_%s', $request->test_name)));
        } catch (Exception $exception) {
            return $this->sendError('Error by test application',
                $exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
        * @OA\Get(
        *  path="/api/v1/training/exercise-sessions/{exercise_session_id}/tests/{type_test_exercise}/sessions/players/{player_id}",
        *  tags={"ExerciseSession"},
        *  summary="Retrieve detail session frecuency cardiac and gps -
        *  Retorna detalle de aplicacion de frecuencia cardiaca y gps",
        *  operationId="show-test-application-session",
        *  description="Retrieve detail session frecuency cardiac and gps -
        *  Retorna detalle de aplicacion de frecuencia cardiaca y gps",
        *  security={{"bearerAuth": {} }},
        *  @OA\Parameter( ref="#/components/parameters/_locale" ),
        *  @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
        *  @OA\Parameter( ref="#/components/parameters/type_test_exercise" ),
        *  @OA\Parameter( ref="#/components/parameters/player_id" ),
        *  @OA\Response(
        *      response=200,
        *      ref="#/components/responses/reponseSuccess"
        *  ),
        *  @OA\Response(
        *      response="401",
        *      ref="#/components/responses/notAuthenticated"
        *  ),
        *  @OA\Response(
        *      response="404",
        *      ref="#/components/responses/resourceNotFound"
        *  )
        * )
        */
    /**
     * Show Test application to Fisiotherapy
     *
     * @return Response
     */
    public function showTestApplication($exercise_session_id, $type_test_exercise, $player_id)
    {
        $application = $this->sessionService->getDetailTestApplication($type_test_exercise,
            $exercise_session_id, $player_id);

        return $this->sendResponse($application, 'Session detail');
    }

    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/training/exercise-sessions/{code}/pdf",
     *  tags={"Team/Exercise/Session"},
     *  summary="PDF exercise session - PDF de sesion de ejercicio",
     *  operationId="exercise-sessions-pdf",
     *  description="Return PDF exercise session - Retorna PDF de sesion de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/code"),
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
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
    public function generatePdf($exercise_session_code)
    {
        $session = $this->sessionService->loadPdf($exercise_session_code);

        try {
            $dompdf = App::make('dompdf.wrapper');
            $dompdf->setPaper('a3', 'landscape');
            $pdf = $dompdf->loadView('training::session-exercise', compact('session'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'attachment; filename="' . sprintf('exercise-%s.pdf', $session->code) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving pdf exercise',
                $exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
