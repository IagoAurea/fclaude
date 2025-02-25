<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Services\ExerciseSessionService;
use Modules\Training\Http\Requests\UpdateOrderExerciseRequest;
use Modules\Training\Services\ExerciseSessionExerciseService;
use Modules\Training\Http\Requests\StoreExerciseSessionExerciseRequest;
use Modules\Training\Http\Requests\UpdateExerciseSessionExerciseRequest;
use Modules\Training\Repositories\Interfaces\ExerciseSessionExerciseRepositoryInterface;

class ExerciseSessionExerciseController extends BaseController
{
    /**
     * @var $sessionExerciseRepository
     */
    protected $sessionExerciseRepository;

    /**
     * @var $sessionExerciseService
     */
    protected $sessionExerciseService;
    
    /**
     * @var $exerciseSessionService
     */
    protected $exerciseSessionService;


    public function __construct(
        ExerciseSessionExerciseRepositoryInterface $sessionExerciseRepository,
        ExerciseSessionExerciseService $sessionExerciseService,
        ExerciseSessionService $exerciseSessionService,
    )
    {
        $this->sessionExerciseRepository = $sessionExerciseRepository;
        $this->sessionExerciseService = $sessionExerciseService;
        $this->exerciseSessionService = $exerciseSessionService;
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/exercises/exercise-sessions/{exercise_session_id}/exercises/order",
    *       tags={"ExerciseSession"},
    *       summary="Update order exercises into exercise session -
    *       Actualiza orden de los ejercicios en una sesión de ejercicio ",
    *       operationId="exercise-sessions-exercise-order",
    *       description="Update order exercises into exercise session -
    *       Actualiza orden de los ejercicios en una sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateOrderExerciseRequest")
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
     * Update order exercises in Exercise Session.
     * @param UpdateOrderExerciseRequest $request
     * @return Response
     */
    public function updateOrderExercises(UpdateOrderExerciseRequest $request, $exercise_session_id)
    {
        try {
            $updateOrder= $this->sessionExerciseService->updateOrderExercises($exercise_session_id, $request);

            return $this->sendResponse($updateOrder,
                trans('training::messages.exercise_session_exercise_update_order'));
        } catch (Exception $exception) {
            return $this->sendError('Error by updating order exercises to exercise eession', $exception->getMessage());
        }
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/exercises/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Stored Exercise into Session - guardar un nuevo ejercicio en una Sesión de ejercicio ",
    *       operationId="exercise-sessions-exercise-store",
    *       description="Store a new exercise into sessions - Guarda un nuevo ejercicio en una Sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreExerciseSessionExerciseRequest")
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
     * Store a new Exercise into Exercise Session.
     * @param StoreExerciseSessionExerciseRequest $request
     * @return Response
     */
    public function store(StoreExerciseSessionExerciseRequest $request)
    {
        try {
            $sessionExercise= $this->sessionExerciseService->createExerciseSessionExercise($request);

            return $this->sendResponse(
                $sessionExercise, trans('training::messages.exercise_session_exercise_store'), Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return $this->sendError('Error by Adding Exercise to Exercise Session', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/exercises/exercise-sessions/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Updated Exercise into Session - Actualiza un ejercicio en una Sesión de ejercicio ",
    *       operationId="exercise-sessions-exercise-update",
    *       description="Store a exercise into sessions - Actualiza un ejercicio en una Sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateExerciseSessionExerciseRequest")
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
     * Update a Exercise into Exercise Session.
     * @param UpdateExerciseSessionExerciseRequest $request
     * @return Response
     */
    public function update(UpdateExerciseSessionExerciseRequest $request, $code)
    {
        try {
            $this->sessionExerciseRepository->update(
                $request->all(),
                ['code' => $code]
            );

            $sessionExercise = $this->sessionExerciseRepository->findOneBy(['code' => $code]);

            $this->exerciseSessionService
                ->updateDurationIntensityDifficultyExerciseSession($sessionExercise->exercise_session_id);

            return $this->sendResponse($sessionExercise, trans('training::messages.exercise_session_exercise_update'));
        } catch (Exception $exception) {
            return $this->sendError('Error by Updating Exercise to Exercise Session', $exception->getMessage());
        }
    }

     /**
    * @OA\Get(
    *       path="/api/v1/training/exercises/exercise-sessions/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show exercise into sessions - Ver los datos de una ejercicio en una Sesión de ejercicio",
    *       operationId="show-exercise-sessions-exercise",
    *       description="Return data to exercise into sessions  -
    *       Retorna los datos de un ejercicio en una Sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
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
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        try {
            $sessionExercise = $this->sessionExerciseRepository->findExerciseSessionExerciseByCode($code);

            return $this->sendResponse($sessionExercise, 'Exercise information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Exercise', $exception->getMessage());
        }
    }

    /**
     * Show the list of Exercises  by search.
     * @param int $exercise_session_code
     * @param string $search
     * @param string $order
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/training/exercises/exercise-sessions/{exercise_session_code}/{search}/{order}",
     *   tags={"ExerciseSession"},
     *   summary="List exercises exercise-sessions - Ver los ejercicios de una Sesión de ejercicio",
     *   operationId="list-exercise-sessions-exercise",
     *   description="Return exercises to exercise-sessions  - Retorna los ejercicios de una Sesión de ejercicio",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Parameter( ref="#/components/parameters/exercise_session_code" ),
     *   @OA\Parameter( ref="#/components/parameters/search" ),
     *   @OA\Parameter( ref="#/components/parameters/order" ),
     *   @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function searchExercises($exercise_session_code,$search,$order)
    {
        try {

            $exercises = $this->sessionExerciseRepository->searchExercises($exercise_session_code,$search,$order);

            return $this->sendResponse($exercises, 'List of Exercise  By Search');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving List of Exercise ', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/training/exercises/exercise-sessions/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete exercise into sessions- Elimina una ejercicio en una Sesión de ejercicio",
    *       operationId="exercise-sessions-exercise-delete",
    *       description="Delete a exercise into sessions - Elimina un ejercicio de una Sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
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
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     */
    public function destroy($code)
    {
        try {
            $exercise = $this->sessionExerciseRepository->findOneBy(["code" => $code]);

            if (!$exercise) {
                return $this->sendError("Error", "Exercise not found", Response::HTTP_NOT_FOUND);
            }

            $exercise_session_id = $exercise->exercise_session_id;

            $delete = $this->sessionExerciseRepository->delete($exercise->id);

            if ($delete) {
                $this->exerciseSessionService
                    ->updateDurationIntensityDifficultyExerciseSession($exercise_session_id);
            }

            return $this->sendResponse(null,
                trans('training::messages.exercise_session_exercise_delete'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Exercise to Exercise Session', $exception->getMessage());
        }
    }
   
}
