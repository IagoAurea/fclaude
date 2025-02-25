<?php

namespace Modules\Injury\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;

class InjuryController extends BaseController
{
    /**
     * @var $injuryRepository
     */
    protected $injuryRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(InjuryRepositoryInterface $injuryRepository)
    {
        $this->injuryRepository = $injuryRepository;
    }

    /**
     * Display a listing of affected side types types.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/injuries/affected-side-types",
     *  tags={"Injury"},
     *  summary="Injury Affected Side Types Index - Listado de Lados Afectados de Lesiones",
     *  operationId="list-injury-affected-side-types",
     *  description="Returns a list of injury extrinsic affected side types - Retorna listado de tipos de lados afectados de lesiones",
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
    public function affectedSidesTypes()
    {
        return $this->sendResponse(
            $this->injuryRepository->getAffectedSideTypes(),
            'List Injury Affected Side Types'
        );
    }
}
