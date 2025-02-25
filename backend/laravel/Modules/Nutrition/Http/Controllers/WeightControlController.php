<?php

namespace Modules\Nutrition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Http\Requests\StoreWeightControlRequest;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Nutrition\Repositories\Interfaces\WeightControlRepositoryInterface;


class WeightControlController extends BaseController
{
    /**
     * @var $weightControlRepository
     */
    protected $weightControlRepository;
    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    public function __construct(
        WeightControlRepositoryInterface $weightControlRepository,
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->weightControlRepository = $weightControlRepository;
        $this->playerRepository = $playerRepository;
    }


    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/weight-control/{player_id}",
    *       tags={"Nutrition"},
    *       summary="Get list weight control - Lista de control de peso por jugador",
    *       operationId="list-weight-control",
    *       description="Return data list  weight control  - Retorna listado de control de peso",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * Display a listing of the Weight Controls of the Player .
     * @return Response
     */
    public function index($id)
    {
        $weightControls = $this->weightControlRepository->findAllWeightControlsById($id);

        return $this->sendResponse($weightControls, 'List of Weight Control');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/nutrition/weight-control",
    *       tags={"Nutrition"},
    *       summary="Stored weight control - guardar un nuevo control de peso ",
    *       operationId="weight-control-store",
    *       description="Store a new weight control - Guarda un nuevo control de peso",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreWeightControlRequest")
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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreWeightControlRequest $request)
    {
        try {
            $weightControlData = $this->weightControlRepository->create($request->all());

            $this->playerRepository->update(['weight' => $weightControlData->weight], ['id' => $request->player_id]);

            return $this->sendResponse($weightControlData, 'Weight Control stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Weight Control', $exception->getMessage());
        }
    }

  
}
