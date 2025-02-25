<?php

namespace Modules\Package\Http\Controllers;


use App\Http\Controllers\Rest\BaseController;
use Modules\Package\Services\SubpackageService;

class SubpackageSportController extends BaseController
{
    /**
     * @var object
     */
    protected $subpackageService;

    public function __construct(SubpackageService $subpackageService)
    {
        $this->subpackageService = $subpackageService;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/subpackages/{subpackage_id}/sports",
    *       tags={"Packages"},
    *       summary="Get show sports of subpackage - Muestra los deportes de un subpaquete",
    *       operationId="subpackage-sport",
    *       description="Return show sports subpackage - Retorna  los deportes de un subpaquete",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/subpackage_id" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
    * )
    */
    /**
     * Show the specified resource.
     * @param int $id
     */
    public function index($subpackage_id)
    {
        $subpackage = $this->subpackageService->getSubpackageSports($subpackage_id);

        return $this->sendResponse($subpackage, 'Sports of subpackage');
    }

    
}
