<?php

namespace Modules\Team\Http\Controllers;

use Modules\Sport\Entities\Sport;
use App\Http\Controllers\Rest\BaseController;
use Modules\Team\Repositories\Interfaces\TeamModalityRepositoryInterface;

class TeamModalityController extends BaseController
{
    /**
     * @var $teamModalityRepository
     */
    protected $teamModalityRepository;


    public function __construct(TeamModalityRepositoryInterface $teamModalityRepository)
    {
        $this->teamModalityRepository = $teamModalityRepository;
    }

    /**
     *  * @OA\Get(
     *  path="/api/v1/teams/modalities/{sport_code}",
     *  tags={"Team"},
     *  summary="Get list modalities by sport - Lista de modalidades por equipo",
     *  operationId="list-genders-team",
     *  description="Return data list modalities by sport - Retorna listado de modalidades por equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
     * Display a listing of team modality.
     * @param Sport
     * @return Response
     */
    public function index(Sport $sport)
    {
        $teamsModality = $this->teamModalityRepository->findBySportAndTranslated($sport->code);

        return $this->sendResponse($teamsModality, 'List Team Modalities by Sport');
    }
}
