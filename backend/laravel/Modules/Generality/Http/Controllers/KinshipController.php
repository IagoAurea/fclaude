<?php

namespace Modules\Generality\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Repositories\Interfaces\KinshipRepositoryInterface;

class KinshipController extends BaseController
{
    /**
     * @var $kinshipRepository
     */
    protected $kinshipRepository;

    public function __construct(KinshipRepositoryInterface $kinshipRepository)
    {
        $this->kinshipRepository = $kinshipRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/kinships",
    *       tags={"General"},
    *       summary="Get list Kinships - Lista de parentescos",
    *       operationId="list-kinships",
    *       security={{"bearerAuth": {} }},
    *       description="Return data list kinships - Retorna listado de parentescos",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       )
    * )
    */
    /**
     * Display a listing the kinship.
     * @return Response
     */
    public function index()
    {
        $kinships = $this->kinshipRepository->findAllTranslated();

        return $this->sendResponse($kinships, 'List Kinships');
    }
}
