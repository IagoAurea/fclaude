<?php

namespace Modules\Team\Http\Controllers;

use Modules\Team\Cache\GenderCache;
use App\Http\Controllers\Rest\BaseController;

class GenderController extends BaseController
{
    /**
     * @var $genderCache
     */
    protected $genderCache;

    /**
     * @return void
     */
    public function __construct(GenderCache $genderCache)
    {
        $this->genderCache = $genderCache;
    }
    /**
     *  * @OA\Get(
     *  path="/api/v1/teams/genders",
     *  tags={"Team"},
     *  summary="Get list Genders Teams - Lista de generos de equipos",
     *  operationId="list-genders-team",
     *  description="Return data list genders team  - Retorna listado de genero de equipos",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Team genders listing response",
     *      @OA\JsonContent(
     *          ref="#/components/responses/reponseSuccess"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    /**
     * Return gender team.
     * @return Response
     */
    public function __invoke()
    {
        return $this->sendResponse($this->genderCache->findAllTranslated(), 'List Genders of team');
    }
}
