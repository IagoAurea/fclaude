<?php

namespace Modules\Injury\Http\Controllers;

use Modules\Injury\Repositories\Interfaces\InjuryLocationRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class InjuryLocationController extends BaseController
{
    /**
     * @var $injuryLocationRepository
     */
    protected $injuryLocationRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(InjuryLocationRepositoryInterface $injuryLocationRepository)
    {
        $this->injuryLocationRepository = $injuryLocationRepository;
    }

    /**
     * Display a listing of injury situation types.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/injuries/locations",
     *      tags={"Injury"},
     *      summary="Injury Locations Index - Listado de Locaciones de Lesiones",
     *      operationId="list-injury-locations",
     *      description="Returns a list of possible injury locations - Retorna listado de locaciones de lesiones",
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
        $locations = $this->injuryLocationRepository->findAllTranslated();

        return $this->sendResponse($locations, 'List injury locations');
    }
}
