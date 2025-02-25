<?php

namespace Modules\AlumnControl\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\AlumnControl\Entities\DailyControlItem;
use Modules\AlumnControl\Services\DailyControlItemService;
use Modules\AlumnControl\Http\Requests\StoreDailyControlItemRequest;
use Modules\AlumnControl\Http\Requests\UpdateDailyControlItemRequest;

class DailyControlItemController extends BaseController
{
    /**
     * @var object
     */
    protected $controlItemService;

    /**
     * Create a new controller instance
     */
    public function __construct(
        DailyControlItemService $controlItemService
    ) {
        $this->controlItemService = $controlItemService;
    }

    /**
     * Lists all the daily control items translated
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/daily-control/items",
     *  tags={"Alumn/DailyControl/Items"},
     *  summary="Daily Control Item Store",
     *  operationId="daily-control-item-list",
     *  description="Lists all daily control items from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information from all daily control items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlItemListResponse"
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
        $items = $this->controlItemService->index();
        
        return $this->sendResponse($items, 'List Daily Control Items');
    }

    /**
     * Function to store a new daily control item into the database
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/daily-control/items",
     *  tags={"Alumn/DailyControl/Items"},
     *  summary="Daily Control Item Store",
     *  operationId="daily-control-item-store",
     *  description="Stores a new daily control item into the database",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreDailyControlItemRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information of recently stored daily control item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlItemStoreResponse"
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
    public function store(StoreDailyControlItemRequest $request)
    {
        try {
            $item = $this->controlItemService->store($request->except('image'), $request->image);
      
            return $this->sendResponse($item, 'Successfully stored a daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing alumn daily control item', $exception->getMessage());
        }
    }

    /**
     * Retrieves a single daily control item
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/daily-control/items/{daily_control_item_id}",
     *  tags={"Alumn/DailyControl/Items"},
     *  summary="Daily Control Item Show",
     *  operationId="daily-control-item-show",
     *  description="Shows an existent daily control item into from database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/daily_control_item_id"),
     *  @OA\Response(
     *      response=200,
     *      description="Retrieves a information of recently stored daily control item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlItemShowResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(DailyControlItem $dailyControlItem)
    {
        try {
            $item = $this->controlItemService->show($dailyControlItem);
        
            return $this->sendResponse($item, 'Daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving alumn daily control item', $exception->getMessage());
        }
    }

    /**
     * Function to update an existent daily control item from the database
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/daily-control/items/{daily_control_item_id}",
     *  tags={"Alumn/DailyControl/Items"},
     *  summary="Daily Control Item Update",
     *  operationId="daily-control-item-update",
     *  description="Updates an existent daily control item from the database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/daily_control_item_id"),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/UpdateDailyControlItemRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Does not retrieves any kind of information",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlItemUpdateResponse"
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
    public function update(UpdateDailyControlItemRequest $request, DailyControlItem $dailyControlItem)
    {
        try {
            $item = $this->controlItemService->update(
                $dailyControlItem,
                $request->except('image'),
                $request->image
            );

            return $this->sendResponse($item, 'Successfully updated a daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating alumn daily control item', $exception->getMessage());
        }
    }

    /**
     * Deletes an existent daily control item from the database
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/daily-control/items/{daily_control_item_id}",
     *  tags={"Alumn/DailyControl/Items"},
     *  summary="Daily Control Item Delete",
     *  operationId="daily-control-item-delete",
     *  description="Deletes an existent daily control item from the database",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/daily_control_item_id"),
     *  @OA\Response(
     *      response=200,
     *      description="Does not retrieves any kind of information",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlItemDeleteResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function destroy(DailyControlItem $dailyControlItem)
    {
        try {
            $item = $this->controlItemService->destroy($dailyControlItem);

            return $this->sendResponse($item, 'Successfully destroyed a daily control item');
        } catch (Exception $exception) {
            return $this->sendError('Error by destroying an alumn daily control item', $exception->getMessage());
        }
    }
}
