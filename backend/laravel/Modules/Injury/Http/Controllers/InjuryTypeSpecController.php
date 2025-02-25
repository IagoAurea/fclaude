<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjuryTypeSpecRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjuryTypeSpecController extends BaseController
{
    /**
     * @var $injuryTypeSpecRepository
     */
    protected $injuryTypeSpecRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjuryTypeSpecRepositoryInterface $injuryTypeSpecRepository)
    {
        $this->injuryTypeSpecRepository = $injuryTypeSpecRepository;
    }

    /**
     * Display a listing of injury types specifications.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/types/{injury_type_id}/specs",
     *  tags={"Injury"},
     *  summary="Injury Types SpecificationsIndex - Listado de Especificacion de Tipos de Lesiones",
     *  operationId="list-injury-types-specs",
     *  description="Returns a list of possible injury types - Retorna listado de tipos de lesiones",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/injury_type_id" ),
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
    public function index($injuryTypeId)
    {
        $injury_types = $this->injuryTypeSpecRepository->findAllTranslated($injuryTypeId);

        return $this->sendResponse($injury_types, 'List injury types specs');
    }
}
