<?php

namespace Modules\Health\Http\Controllers;

use Modules\Health\Repositories\Interfaces\TobaccoConsumptionRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class TobaccoConsumptionController extends BaseController
{
    /**
     * @var $tobaccoConsumptionRepository
     */
    protected $tobaccoConsumptionRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(TobaccoConsumptionRepositoryInterface $tobaccoConsumptionRepository)
    {
        $this->tobaccoConsumptionRepository = $tobaccoConsumptionRepository;
    }

    /**
     * Display a listing of tobacco consumption.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/tobacco-consumptions",
     *      tags={"Health"},
     *      summary="Get tobacco consumptions list - Lista de tipos de consumno de tabaco",
     *      operationId="list-tobacco-consumptions",
     *      description="Returns a list of tobacco consumptions - Retorna listado de consumos de tabaco",
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
        $tobaccoConsumptions = $this->tobaccoConsumptionRepository->findAllTranslated();

        return $this->sendResponse($tobaccoConsumptions, 'List Tobacco Consumption');
    }
}
