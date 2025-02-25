<?php


namespace Modules\Team\Http\Controllers;


use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Team\Repositories\Interfaces\TypeLineupRepositoryInterface;

class TypeLineupController extends BaseController
{

    /**
     * Repository TypeLineup
     * @var $typeLineupRepository
     */
    protected $typeLineupRepository;

    /**
     * TypeLineupController constructor.
     * @param TypeLineupRepositoryInterface $typeLineupRepository
     */
    public function __construct(TypeLineupRepositoryInterface $typeLineupRepository)
    {
        $this->typeLineupRepository = $typeLineupRepository;
    }

    /**
     * List all type lineups
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->typeLineupRepository->findAll(), 'List TypeLineups');
    }

    /**
    * @OA\Get(
    *  path="/api/v1/teams/type-lineups/sport/{sport_code}/{modality_code}",
    *  tags={"Team"},
    *  summary="List typeLineyps by sport and modality",
    *  operationId="list-team-type-lineups-sport",
    *  description="Returns a list of typeLineyps by sport and modality",
    *  security={{"bearerAuth": {} }},
    *  @OA\Parameter(ref="#/components/parameters/_locale"),
    *  @OA\Parameter(ref="#/components/parameters/sport_code"),
    *  @OA\Parameter(ref="#/components/parameters/modality_code"),
    *  @OA\Response(
    *      response=200,
    *      ref="#/components/responses/reponseSuccess"
    *  ),
    *  @OA\Response(
    *      response="401",
    *      ref="#/components/responses/notAuthenticated"
    *  )
    * )
    */
    /**
     * Endpoint to get list of typeLineyps by sport and modality
     * @param $sport_code
     * @param null $modality_code "optional"
     * @return JsonResponse
     */
    public function getAllBySportAndModality($sport_code, $modality_code = null)
    {
        return $this->sendResponse($this->typeLineupRepository->findAllBySportAndModality($sport_code, $modality_code),
            "List typeLineups by Sport and Modality");
    }
}
