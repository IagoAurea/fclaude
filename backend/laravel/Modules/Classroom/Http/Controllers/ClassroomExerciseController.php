<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Services\ExerciseService;
use Modules\Exercise\Http\Requests\StoreExerciseRequest;
use Modules\Exercise\Http\Requests\UpdateExerciseRequest;

class ClassroomExerciseController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var $exerciseService
     */
    protected $exerciseService;

    /**
     * @return void
     */
    public function __construct(ExerciseService $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    /**
     * Display a listing of exercise by classroom.
     * @param $team
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/classroom/{classroom_id}/exercises",
     *  tags={"Classroom/Exercise"},
     *  summary="Classroom Exercise Index",
     *  operationId="list-classroom-exercises",
     *  description="Returns a list of all exercises related to a classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/distribution_exercise_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/difficulty"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/intensity"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/user_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/duration"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all exercise items depending on the classroom sent",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListClassroomExerciseResponse"
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
            $exercises = $this->exerciseService->list($request->all(), $classroom);
            
            return $this->sendResponse($exercises, 'List Exercises by Classrooms');
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Stores a new exercise item into the database.
     * @param StoreExerciseRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/classroom/{classroom_id}/exercises",
     *  tags={"Classroom/Exercise"},
     *  summary="Classroom Exercise Store",
     *  operationId="store-classroom-exercises",
     *  description="Returns a list of all exercises related to a classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreClassroomExerciseRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Information about recently stored exercise item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreClassroomExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function store(StoreExerciseRequest $request, Classroom $classroom)
    {
        $permission = Gate::inspect('store-exercise-teacher');

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {

            $exercise = $this->exerciseService->store(
                $request->except('_locale'),
                Auth::id(),
                $classroom,
            );

            $exercise->sport;

            return $this->sendResponse($exercise,
                $this->translator('exercise_controller_store_response_message'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise', $exception->getMessage());
        }
    }

    /**
     * Shows exercise item details
     * @param string $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/classroom/{classroom_id}/exercises/{code}",
     *  tags={"Classroom/Exercise"},
     *  summary="Classroom Exercise Show",
     *  operationId="show-classroom-exercises",
     *  description="Returns an specified exercise related to a classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows a single team exercise item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowClassroomExerciseResponse"
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
            $exercise = $this->exerciseService->show($code);
            return $this->sendResponse($exercise, "Exercise detail");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise', $exception->getMessage());
        }
    }

    /**
     * Updates an existent exercise item.
     * @param UpdateExerciseRequest $request
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/classroom/{classroom_id}/exercises/{code}",
     *  tags={"Classroom/Exercise"},
     *  summary="Classroom Exercise Update",
     *  operationId="update-classroom-exercises",
     *  description="Returns an specified exercise related to a classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateClassroomExerciseRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Exercise update response status",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function update(UpdateExerciseRequest $request, Classroom $classroom, $code)
    {
        try {
            $exercise = $this->exerciseService->update(
                $request->all(), $code
            );

            return $this->sendResponse($exercise, $this->translator('exercise_controller_update_response_message'));
        } catch(Exception $exception) {
            return $this->sendError("Error", $exception->getMessage());
        }
    }

    /**
     * Deletes a exercise.
     *
     * @param UpdateExerciseRequest $request
     * @return Response
     */
    /**
     * Updates an existent exercise item.
     *
     * @param UpdateExerciseRequest $request
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/classroom/{classroom_id}/exercises/{code}",
     *  tags={"Classroom/Exercise"},
     *  summary="Classroom Exercise Delete",
     *  operationId="delete-classroom-exercises",
     *  description="Returns an specified exercise related to a classroom",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Exercise delete response status",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function destroy(Classroom $classroom, $code)
    {
        try {
            $exercise = $this->exerciseService->delete($code);
            return $this->sendResponse($exercise, "Deleted exercise");
        } catch (Exception $exception) {
            return $this->sendError("Error", $exception->getMessage());
        }
    }
}
