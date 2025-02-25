<?php

namespace Modules\Exercise\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\Exercise\Services\EducationLevelService;

// Entities
use Modules\Exercise\Entities\ExerciseEducationLevel;

class ExerciseEducationLevelController extends BaseController
{
    /**
     * @var $educationLevelService
     */
    protected $educationLevelService;

    /**
     * Creates a new controller instance
     */
    public function __construct(EducationLevelService $educationLevelService)
    {
        $this->educationLevelService = $educationLevelService;
    }

    /**
     * Lists all the education level items
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/exercises/education-levels",
     *  tags={"Exercise/EducationLevel"},
     *  summary="Exercise Education Level Index",
     *  operationId="exercise-education-level-index",
     *  description="Lists all the education level items from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information from all daily control items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListExerciseEducationLevelResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index()
    {
        $levels = $this->educationLevelService->index();

        return $this->sendResponse($levels, 'Exercise Education Levels');
    }

    /**
     * Stores a new exercise education level item into the database
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/exercises/education-levels",
     *  tags={"Exercise/EducationLevel"},
     *  summary="Exercise Education Level Store",
     *  operationId="exercise-education-level-store",
     *  description="Stores an education level item into database",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreTranslatableItemRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information of recently stored exercise education level",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SingleTranslatableItemResponse"
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
    public function store(Request $request)
    {
        try {
            $item = $this->educationLevelService->store($request->all());
            return $this->sendResponse($item, 'Successfully stored a daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to show an existent exercise education level item from database
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/exercises/education-levels/{id}",
     *  tags={"Exercise/EducationLevel"},
     *  summary="Exercise Education Level Show",
     *  operationId="exercise-education-level-show",
     *  description="Shows an education level item from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/path_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves exercise education level item info",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SingleTranslatableItemResponse"
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
    public function show(ExerciseEducationLevel $educationLevel)
    {
        try {
            $item = $this->educationLevelService->show($educationLevel);
            return $this->sendResponse($item, 'Education Level Item');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to update an existent education level item from database
     * @return Response
     * 
     * @OA\Put(
     *  path="/api/v1/exercises/education-levels/{id}",
     *  tags={"Exercise/EducationLevel"},
     *  summary="Exercise Education Level Update",
     *  operationId="exercise-education-level-update",
     *  description="Updates an education level item from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/path_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateTranslatableItemRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves exercise education level item info",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SingleTranslatableItemResponse"
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
    public function update(Request $request, ExerciseEducationLevel $educationLevel)
    {
        try {
            $item = $this->educationLevelService->update(
                $request->all(),
                $educationLevel
            );

            return $this->sendResponse($item, 'Successfully updated an exercise education level item');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to delete an existent education level item from database
     * @return Response
     * 
     * @OA\Delete(
     *  path="/api/v1/exercises/education-levels/{id}",
     *  tags={"Exercise/EducationLevel"},
     *  summary="Exercise Education Level Delete",
     *  operationId="exercise-education-level-delete",
     *  description="Deletes an education level item from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/path_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves deletion status of item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteTranslatableItemResponse"
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
    public function destroy(ExerciseEducationLevel $educationLevel)
    {
        try {
            $item = $this->educationLevelService->destroy($educationLevel);
            return $this->sendResponse($item, 'Successfully destroyed an education level item');
        } catch (Exception $exception) {
            return $this->sendError('Error by destroying an exercise education level item', $exception->getMessage());
        }
    }
}
