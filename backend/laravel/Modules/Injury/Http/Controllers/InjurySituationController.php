<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjurySituationRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjurySituationController extends BaseController
{
    /**
     * @var $injurySituationRepository
     */
    protected $injurySituationRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjurySituationRepositoryInterface $injurySituationRepository)
    {
        $this->injurySituationRepository = $injurySituationRepository;
    }

    /**
     * Display a listing of injury situation types
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/situation-types",
     *  tags={"Injury"},
     *  summary="Injury Situation Types Index - Listado de Tipos de Situaciones de Lesiones",
     *  operationId="list-injury-situation-types",
     *  description="Returns a list of injury situation types - Retorna listado de tipos de situaciones de lesion",
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
        $situations = $this->injurySituationRepository->findAllTranslated();

        return $this->sendResponse($situations, 'List injury situation types');
    }
}
