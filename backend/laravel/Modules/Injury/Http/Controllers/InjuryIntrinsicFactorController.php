<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjuryIntrinsicFactorRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjuryIntrinsicFactorController extends BaseController
{
    /**
     * @var $injuryIntrinsicFactorRepository
     */
    protected $injuryIntrinsicFactorRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjuryIntrinsicFactorRepositoryInterface $injuryIntrinsicFactorRepository)
    {
        $this->injuryIntrinsicFactorRepository = $injuryIntrinsicFactorRepository;
    }

    /**
     * Display a listing of intrinsic factors
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/intrinsic-factors",
     *  tags={"Injury"},
     *  summary="Injury Intrinsic Factor Index - Listado de Factores Intrinsecos de Lesiones",
     *  operationId="list-injury-intrinsic-factors",
     *  description="Returns a list of injury intrinsic factor types - Retorna listado de tipos de factores intrinsecos de lesiones",
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
        $intrinsic_factors = $this->injuryIntrinsicFactorRepository->findAllTranslated();

        return $this->sendResponse($intrinsic_factors, 'List injury Intrinsic factors');
    }
}
