<?php

namespace Modules\User\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Services\ExerciseService;
use Modules\Exercise\Http\Requests\IndexExerciseRequest;

class UserExerciseController extends BaseController
{
    use PaginateTrait;

    /**
     * @var $exerciseService
     */
    protected $exerciseService;

    public function __construct(
        ExerciseService $exerciseService
    ) {
        $this->exerciseService = $exerciseService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     *
     * * @OA\Get(
     *  path="/api/v1/users/exercises",
     *  tags={"User/Exercise"},
     *  summary="User Exercises Index - Lista de ejercicios del usuario",
     *  operationId="list-user-exercises",
     *  description="Returns a list of all exercises related to a user - Retorna listado de ejercicios del usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/page"),
     *  @OA\Parameter(ref="#/components/parameters/per_page"),
     *  @OA\Parameter(ref="#/components/parameters/sports"),
     *  @OA\Parameter(ref="#/components/parameters/name"),
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
    public function index(IndexExerciseRequest $request)
    {
        $filters = $request->only(['sport', 'name']);

        try {
           $exercises = $this->exerciseService->listByUser(Auth::id(), $filters);

           $paginatedData = $request->page ? $this->paginateWithAllData($exercises, $request) : $exercises;

            return $this->sendResponse($paginatedData, 'List of user exercises');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise list', $exception->getMessage());
        }
    }

    
}
