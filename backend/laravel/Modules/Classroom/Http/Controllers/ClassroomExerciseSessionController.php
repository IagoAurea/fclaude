<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Services\ExerciseSessionService;
use Modules\Training\Http\Requests\StoreExerciseSessionRequest;
use Modules\Training\Http\Requests\UpdateExerciseSessionRequest;

class ClassroomExerciseSessionController extends BaseController
{
    /**
     * @var object $sessionService
     */
    protected $sessionService;

    /**
     * Creates a new controller instance
     */
    public function __construct(ExerciseSessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * Retrieves a list of exercise sessions by search.
     * 
     * @param Request $request
     * @param Classroom $team
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/classroom/{classroom_id}/exercise-sessions",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="Search exercise-sessions - Buscar una Sesión de ejercicio",
     *  operationId="list-exercise-sessions-classroom",
     *  description="Return data to exercise-sessions  - Retorna los datos de una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/classroom_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/order" ),
     *  @OA\Parameter( ref="#/components/parameters/search" ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all related clasroom exercise sessions",
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
    public function index(Request $request, Classroom $classroom)
    {
        try {
            $exerciseSessions = $this->sessionService->list(
                $request->all(),
                $classroom,
            );

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
     *  path="/api/v1/classroom/{classroom_id}/exercise-sessions",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="Stores a new exercise session - Guardar una nueva sesión de ejercicio",
     *  operationId="exercise-sessions-store-classroom",
     *  description="Store a new exercise sessions - Guarda una nueva Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
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
    public function store(StoreExerciseSessionRequest $request, Classroom $classroom)
    {
        $permission = Gate::inspect('store-training-teacher');

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $sessionData = $request->except(
                'exercises', 'execution', 'targets'
            );

            $sessionData['user_id'] = Auth::id();

            $session = $this->sessionService->store(
                $classroom,
                $sessionData,
                $request->exercises,
                $request->execution,
                $request->targets,
                Auth::user(),
            );

            return $this->sendResponse($session, 'Exercise Sessions stored', Response::HTTP_CREATED);
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
     *  path="/api/v1/classroom/{classroom_id}/exercise-sessions/{code}",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="Show exercise-sessions - Ver los datos de una Sesión de ejercicio",
     *  operationId="show-exercise-sessions-classroom",
     *  description="Return data to exercise-sessions - Retorna los datos de una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
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
    public function show(Classroom $classroom, $code)
    {
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
     *  path="/api/v1/classroom/{classroom_id}/exercise-sessions/{code}",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="Edit exercise-sessions - Editar una Sesión de ejercicio",
     *  operationId="exercise-sessions-edit-classroom",
     *  description="Edit a exercise-sessions - Edita una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
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
    public function update(UpdateExerciseSessionRequest $request, Classroom $classroom, $code)
    {
        try {
            $sessionData = $request->except('exercises', 'targets');

            $update = $this->sessionService->update(
                $classroom,
                $code,
                $sessionData,
                $request->targets,
                Auth::user()
            );

            return $this->sendResponse($update, 'Exercise session update', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by Updating Exercise Session', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/classroom/{classroom_id}/exercise-sessions/{code}",
     *  tags={"Classroom/Exercise/Session"},
     *  summary="Delete exercise-sessions - Elimina una Sesión de ejercicio",
     *  operationId="exercise-sessions-delete-classroom",
     *  description="Delete a exercise-sessions - Elimina una Sesión de ejercicio",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/classroom_id"),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function destroy(Classroom $classroom, $code)
    {
        try {
            $delete = $this->sessionService->delete(
                $classroom,
                $code,
                Auth::user()
            );

            return $this->sendResponse($delete, 'Exercise session deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting exercise session', $exception->getMessage());
        }
    }
}
