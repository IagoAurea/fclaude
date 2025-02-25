<?php

namespace Modules\Calculator\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Calculator\Services\CalculatorService;
use Modules\Calculator\Repositories\CalculatorItemTypeRepository;

class CalculatorController extends BaseController
{
    /**
     * @var $calculatorService
     */
    protected $calculatorService;
    
    /**
     * @var $calculatorItemTypeRepository
     */
    protected $calculatorItemTypeRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        CalculatorService $calculatorService, 
        CalculatorItemTypeRepository $calculatorItemTypeRepository
        )
    {
        $this->calculatorService = $calculatorService;
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
    }

    /**
     * Display a listing of calculator items depending on the type sent.
     *  @return Response
     *
     * @OA\Get(
     *   path="/api/v1/calculator/items",
     *   tags={"Calculator"},
     *   summary="Calculator Items Index",
     *   operationId="calculator-items-index",
     *   description="Returns a list of calculator items depending on the item_type sent",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      parameter="item_type",
     *      description="Entity type",
     *      in="query",
     *      name="item_type",
     *      required=true,
     *      example="injury_prevention",
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
    */
    public function index(Request $request)
    {
        try {
            $type = $request->get('item_type');

            $calculatorItems = $this->calculatorService->getItems($type);
            
            return $this->sendResponse($calculatorItems, 'List of Calculator Question Items');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing calculation items', $exception->getMessage());
        }
    }

    /**
     * Saves a set of item responses inside a calculation done
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/calculator/items",
     *  tags={"Calculator"},
     *  summary="Saves a calculation",
     *  operationId="calculator-store-answers",
     *  description="Saves all the answered items from the calculation view",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreCalculatorAnswersRequest"
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
    public function store(Request $request)
    {
        try {
            $point = $this->calculatorService->storeItems($request->all());

            $calculatorItems = [
                'point' => $point,
                'rank' => $this->calculatorItemTypeRepository->getItemType($point)
            ];
            
            return $this->sendResponse($calculatorItems, 'Calculator Answers Successfully Saved');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing set of answers', $exception->getMessage());
        }
    }


    /**
     * Retrieves the full list of all historic evaluations made to the entity
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/calculator/history/{entity_id}",
     *   tags={"Calculator"},
     *   summary="Calculator History Index",
     *   operationId="calculator-history-index",
     *   description="Returns a historic list of calculation responses done in the past depending on the item_type sent",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/entity_id"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
    */
    public function showHistoryList(Request $request, $entityId)
    {
        try {
            $type = $request->get('item_type');

            $history = $this->calculatorService->getHistory($type, $entityId);

            return $this->sendResponse($history, 'Calculator Entity History List');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing set of answers', $exception->getMessage());
        }
    }


    /**
     * Retrieves the specific history answer set of an calculator 
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/calculator/history/{entity_id}/show/{calculator_history_id}",
     *   tags={"Calculator"},
     *   summary="Show Caculator Item Details",
     *   operationId="calculator-history-get-item",
     *   description="Returns a historic list of calculation responses done in the past depending on the item_type sent",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/entity_id"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/calculator_history_id"
     *   ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
    */
    public function showHistoryItem(Request $request, $entityId, $historyId)
    {
        try {
            $type = $request->get('item_type');

            $history = $this->calculatorService->getHistoryItem($type, $entityId, $historyId);

            return $this->sendResponse($history, 'Items of Answered History');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing set of answers', $exception->getMessage());
        }   
    }
}
