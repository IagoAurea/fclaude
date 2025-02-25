<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjuryExtrinsicFactorRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjuryExtrinsicFactorController extends BaseController
{
    /**
     * @var $injuryExtrinsicFactorRepository
     */
    protected $injuryExtrinsicFactorRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjuryExtrinsicFactorRepositoryInterface $injuryExtrinsicFactorRepository)
    {
        $this->injuryExtrinsicFactorRepository = $injuryExtrinsicFactorRepository;
    }

    /**
     * Display a listing of extrinsic factors
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/extrinsic-factors",
     *  tags={"Injury"},
     *  summary="Injury Extrinsic Factor Index - Listado de Factores Extrinsecos de Lesiones",
     *  operationId="list-injury-extrinsic-factors",
     *  description="Returns a list of injury extrinsic factor types - Retorna listado de tipos de factores extrinsecos de lesiones",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
     */
    public function index()
    {
        $injury_extrinsic_factors = $this->injuryExtrinsicFactorRepository->findAllTranslated();

        return $this->sendResponse($injury_extrinsic_factors, 'List injury extrinsic factors');
    }
}
