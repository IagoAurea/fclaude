<?php

namespace Modules\Health\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Health\Repositories\Interfaces\AreaBodyRepositoryInterface;

class AreaBodyController extends BaseController
{
    /**
     * @var $areaBodyRepository
     */
    protected $areaBodyRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(AreaBodyRepositoryInterface $areaBodyRepository)
    {
        $this->areaBodyRepository = $areaBodyRepository;
    }

    /**
     * Display a listing of body areas.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/health/areas-body",
     *      tags={"Health"},
     *      summary="Get body areas list - Lista de areas corporales",
     *      operationId="list-body-areas",
     *      description="Returns a list of body areas - Retorna listado de areas del cuerpo",
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
        $areasBody = $this->areaBodyRepository->findAllTranslated();
        return $this->sendResponse($areasBody, 'List Areas body');
    }
}
