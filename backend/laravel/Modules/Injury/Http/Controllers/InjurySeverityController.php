<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjurySeverityController extends BaseController
{
    /**
     * @var $injurySeverityRepository
     */
    protected $injurySeverityRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjurySeverityRepositoryInterface $injurySeverityRepository)
    {
        $this->injurySeverityRepository = $injurySeverityRepository;
    }

    /**
     * Display a listing of injury severities
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/severities",
     *  tags={"Injury"},
     *  summary="Injury Severities Index - Listado de Severidad de Lesiones",
     *  operationId="list-injury-severities",
     *  description="Returns a list of injury severities - Retorna listado de severidades de lesiones",
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
        $injury_severities = $this->injurySeverityRepository->findAllTranslated();

        return $this->sendResponse($injury_severities, 'List injury severities');
    }
}
