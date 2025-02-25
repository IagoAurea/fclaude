<?php

namespace Modules\Competition\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionRepositoryInterface;

class TypeCompetitionsController extends BaseController
{
    /**
     * Type Competition Repository
     * @var $typeCompetitionRepository
     */
    protected $typeCompetitionRepository;

    /**
     * TypeCompetitionsController constructor.
     * @param TypeCompetitionRepositoryInterface $typeCompetitionRepository
     */
    public function __construct(TypeCompetitionRepositoryInterface $typeCompetitionRepository)
    {
        $this->typeCompetitionRepository = $typeCompetitionRepository;
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/type-competitions/{sport_code}",
     *  tags={"Competitions"},
     *  summary="Type Competitions - Listado de tipos de Competicion",
     *  operationId="type-competition-index",
     *  description="Get Type Competitions - Listado de tipos de Competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
    /**
     * Get all Type Competitions
     * @return JsonResponse
     */
    public function index($sport)
    {
        return $this->sendResponse($this->typeCompetitionRepository->findBySport($sport),
            'List Type Competitions');
    }
}
