<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjuryTypeRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjuryTypeController extends BaseController
{
    /**
     * @var $injuryTypeRepository
     */
    protected $injuryTypeRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjuryTypeRepositoryInterface $injuryTypeRepository)
    {
        $this->injuryTypeRepository = $injuryTypeRepository;
    }

    /**
     * Display a listing of injury types.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/types",
     *  tags={"Injury"},
     *  summary="Injury Types Index - Listado de Tipos de Lesiones",
     *  operationId="list-injury-types",
     *  description="Returns a list of possible injury types - Retorna listado de tipos de lesiones",
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
        $injury_types = $this->injuryTypeRepository->findAllTranslated();

        return $this->sendResponse($injury_types, 'List injury types');
    }
}
