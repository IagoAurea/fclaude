<?php

namespace Modules\Exercise\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\Exercise\Services\ContentBlockService;

// Entities
use Modules\Exercise\Entities\ExerciseContentBlock;

class ExerciseContentBlockController extends BaseController
{
    /**
     * @var $contentBlockService
     */
    protected $contentBlockService;

    /**
     * Creates a new controller instance
     */
    public function __construct(ContentBlockService $contentBlockService)
    {
        $this->contentBlockService = $contentBlockService;
    }

    /**
     * Lists all the exercise content blocks items
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/exercises/content-blocks",
     *  tags={"Exercise/ContentBlock"},
     *  summary="Exercise Content Block Index",
     *  operationId="exercise-content-block-index",
     *  description="Lists all the exercise level items from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information from all exercise content block items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListExerciseContentBlockResponse"
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
        $levels = $this->contentBlockService->index();

        return $this->sendResponse($levels, 'Exercise Content Blocks');
    }

    /**
     * Function to store a new exercise content block item
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/exercises/content-blocks",
     *  tags={"Exercise/ContentBlock"},
     *  summary="Exercise Content Block Store",
     *  operationId="exercise-content-block-store",
     *  description="Stores an content level item into database",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreTranslatableItemRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information of recently stored exercise content block",
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
            $item = $this->contentBlockService->store($request->all());
            return $this->sendResponse($item, 'Successfully stored a daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to show an existent exercise content block item from database
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/exercises/content-blocks/{id}",
     *  tags={"Exercise/ContentBlock"},
     *  summary="Exercise Content Block Show",
     *  operationId="exercise-content-block-show",
     *  description="Shows an content block item from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/path_id" ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves exercise content block item info",
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
    public function show(ExerciseContentBlock $contentBlock)
    {
        try {
            $item = $this->contentBlockService->show($contentBlock);
            return $this->sendResponse($item, 'Education Level Item');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to update an existent exercise content block item from database
     * @return Response
     * 
     * @OA\Put(
     *  path="/api/v1/exercises/content-blocks/{id}",
     *  tags={"Exercise/ContentBlock"},
     *  summary="Exercise Content Block Update",
     *  operationId="exercise-content-block-update",
     *  description="Updates a content block item from database",
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
     *      description="Retrieves exercise content block item info",
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
    public function update(Request $request, ExerciseContentBlock $contentBlock)
    {
        try {
            $item = $this->contentBlockService->update(
                $request->all(),
                $contentBlock
            );

            return $this->sendResponse($item, 'Successfully updated an exercise education level item');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating exercise education level item', $exception->getMessage());
        }
    }

    /**
     * Function to delete an existent content block item from database
     * @return Response
     * 
     * @OA\Delete(
     *  path="/api/v1/exercises/content-blocks/{id}",
     *  tags={"Exercise/ContentBlock"},
     *  summary="Exercise Content Block Delete",
     *  operationId="exercise-content-block-delete",
     *  description="Deletes an exercise content block item from database",
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
    public function destroy(ExerciseContentBlock $contentBlock)
    {
        try {
            $item = $this->contentBlockService->destroy($contentBlock);
            return $this->sendResponse($item, 'Successfully destroyed an education level item');
        } catch (Exception $exception) {
            return $this->sendError('Error by destroying an exercise education level item', $exception->getMessage());
        }
    }
}
