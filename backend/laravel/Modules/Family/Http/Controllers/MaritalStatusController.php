<?php

namespace Modules\Family\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Family\Repositories\Interfaces\FamilyRepositoryInterface;

class MaritalStatusController extends BaseController
{
    /**
     * @var $playerFamilyRepository
     */
    protected $playerFamilyRepository;

    /**
     * @return void
     */
    public function __construct(FamilyRepositoryInterface $playerFamilyRepository)
    {
        $this->playerFamilyRepository = $playerFamilyRepository;
    }

    /**
     * Return marital status.
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/family/marital-statuses",
     *      tags={"Family"},
     *      summary="Get marital statuses list - Lista de estados maritales",
     *      operationId="list-marital-statuses",
     *      description="Returns a list of marital statuses - Retorna listado de estados maritales de alergias",
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
    public function __invoke()
    {
        return $this->sendResponse(
            $this->playerFamilyRepository->getMaritalStatusTypes(),
            'List of Family Marital Statuses'
        );
    }
}
