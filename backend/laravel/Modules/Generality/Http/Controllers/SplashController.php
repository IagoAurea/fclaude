<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Generality\Cache\SplashCache;
use App\Http\Controllers\Rest\BaseController;

class SplashController extends BaseController
{
     /**
     * @var $splashCache
     */
    protected $splashCache;

    public function __construct(SplashCache $splashCache)
    {
        $this->splashCache = $splashCache;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *  path="/api/v1/splashs",
     *  tags={"General"},
     *  summary="Shows splashs - Lista los splash",
     *  operationId="splash-list",
     *  description="Shows list splashs active - Muestra listado de splashs activos",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information splash",
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
    /**
     * @OA\Get(
     *  path="/api/v1/splashs/{external}",
     *  tags={"General"},
     *  summary="Shows splashs - Lista los splash",
     *  operationId="splash-list-external",
     *  description="Shows list splashs externo - Muestra listado de splashs externo",
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/external"),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information splash",
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
    public function index($type = 'internal')
    {
        $splashes = $this->splashCache->findByType($type);

        return $this->sendResponse($splashes, 'List Splashes');
    }

}
