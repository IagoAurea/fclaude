<?php

namespace Modules\Health\Http\Controllers;

use Modules\Health\Repositories\Interfaces\AlcoholConsumptionRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class AlcoholConsumptionController extends BaseController
{
    /**
     * @var $alcoholConsumptionRepository
     */
    protected $alcoholConsumptionRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(AlcoholConsumptionRepositoryInterface $alcoholConsumptionRepository)
    {
        $this->alcoholConsumptionRepository = $alcoholConsumptionRepository;
    }

    /**
     * Display a listing of alcohol consumption.
     * @return Response
     * 
     *  @OA\Get(
     *      path="/api/v1/health/alcohol-consumptions",
     *      tags={"Health"},
     *      summary="Get alcohol consumptions list - Lista de consumos de alcohol",
     *      operationId="list-alcohol-consumption",
     *      description="Returns a list of alcohol consumption types - Retorna listado de tipos de consumos de alcohol",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
    */
    public function index()
    {
        $alcoholConsumption = $this->alcoholConsumptionRepository->findAllTranslated();

        return $this->sendResponse($alcoholConsumption, 'List Alcohol Consumption');
    }
}
