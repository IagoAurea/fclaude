<?php

namespace Modules\Competition\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Competition\Repositories\Interfaces\TypeModalityMatchRepositoryInterface;

class TypeModalityMatchController extends BaseController
{
    /**
     * Type Modality Match Repository
     * @var $typeModalityMatchRepository
     */
    protected $typeModalityMatchRepository;

    /**
     * TypeModalityMatchsController constructor.
     * @param TypeModalityMatchRepositoryInterface $typeModalityMatchRepository
     */
    public function __construct(TypeModalityMatchRepositoryInterface $typeModalityMatchRepository)
    {
        $this->typeModalityMatchRepository = $typeModalityMatchRepository;
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/match/type-modalities/{sport_code}",
     *  tags={"Competition/Match"},
     *  summary="Type Modalities Match - Listado de tipos de modalidades de partido",
     *  operationId="type-modality-match-index",
     *  description="Get Type Modalities Match - Listado de tipos de modalidades de partido",
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
     * Get all Type Modalities Match
     * @return JsonResponse
     */
    public function index($sport)
    {
        return $this->sendResponse($this->typeModalityMatchRepository->findBySport($sport),
            'List Type modalities by sport');
    }
}
