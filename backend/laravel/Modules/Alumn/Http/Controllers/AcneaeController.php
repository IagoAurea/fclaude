<?php

namespace Modules\Alumn\Http\Controllers;

use Modules\Alumn\Repositories\Interfaces\AcneaeTypeRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AcneaeController extends BaseController
{
    /**
     * @var $acneaeRepository
     */
    protected $acneaeRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        AcneaeTypeRepositoryInterface $acneaeRepository
    ) {
        $this->acneaeRepository = $acneaeRepository;
    }

    /**
     * Function to list all alumns related to a specific classroom
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/acneae/types",
     *  tags={"Acneae"},
     *  summary="Acneae Index List - Listado de Acneae",
     *  operationId="acneae-index",
     *  description="Shows a list of acneae",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index()
    {
        $acneae = $this->acneaeRepository->findAllTranslated();

        return $this->sendResponse($acneae, 'Acneae types');
    }
}
