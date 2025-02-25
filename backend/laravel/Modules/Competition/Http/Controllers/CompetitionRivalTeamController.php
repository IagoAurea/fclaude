<?php

namespace Modules\Competition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Modules\Competition\Services\RivalTeamService;
use Modules\Competition\Services\CompetitionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Competition\Http\Requests\CompetitionRivalTeamRequest;
use Modules\Competition\Http\Requests\UpdateCompetitionRivalTeamRequest;
use Modules\Competition\Repositories\Interfaces\CompetitionRivalTeamRepositoryInterface;

class CompetitionRivalTeamController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * @var $competitionRivalTeamRepository
     */
    protected $competitionRivalTeamRepository;

    /**
     * @var $competitionService
     */
    protected $competitionService;

    /**
     * @var $rivalTeamService
     */
    protected $rivalTeamService;

    public function __construct(
        CompetitionRivalTeamRepositoryInterface $competitionRivalTeamRepository,
        CompetitionService $competitionService,
        RivalTeamService $rivalTeamService
    ) {
        $this->competitionRivalTeamRepository = $competitionRivalTeamRepository;
        $this->competitionService = $competitionService;
        $this->rivalTeamService = $rivalTeamService;
    }

    /**
     * Get all competition rival teams
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->competitionRivalTeamRepository->findAll(), 'List Competition Rival Teams');
    }

    /**
     * Stores a new rival team into the database
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $rivalTeam = $this->rivalTeamService->store($request->all(), Auth::user());

        return $this->sendResponse($rivalTeam, 'Rival Team Successfully Created');
    }

    /**
     * Stores a new rival team into the database
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            $response = $this->rivalTeamService->update($id, $request->all());

            return $this->sendResponse($response, $this->translator('rival_team_updated'));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError($this->translator('rival_team_not_found'),
                $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('rival_team_error'),
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     *  @OA\Delete(
     *  path="/api/v1/competitions/rival-teams/{id}",
     *  tags={"Competitions"},
     *  summary="Competition delete rival teams - Elimina rival de competicion",
     *  operationId="competition-delete-rival-teams",
     *  description="Competition delete rival teams - Elimina rival de competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/id" ),
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
     * Delete a new rival team into the database
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $response = $this->rivalTeamService->delete($id);

        return $this->sendResponse($response, $this->translator('rival_team_deleted'));
    }

    /**
     * Get rival teams by competition.
     * @param $competition_id
     * @return JsonResponse
     */
    public function getAllByCompetitionId($competition_id)
    {
        return $this->sendResponse(
            $this->competitionRivalTeamRepository->findAllByCompetitionId($competition_id),
            'List rival teams filtered by competition'
        );
    }

    /**
    *  @OA\Post(
    *  path="/api/v1/competitions/rival-teams/bulk",
    *  tags={"Competitions"},
    *  summary="Competition rival teams match store - Registrar equipos rivales de partidos de competicion",
    *  operationId="competitions-match-rival-team-store",
    *  description="Competition rival teams match store - Registrar equipos rivales de partidos de competicion",
    *  security={{"bearerAuth": {} }},
    *  @OA\Parameter( ref="#/components/parameters/_locale" ),
    *  @OA\RequestBody(
    *      required=true,
    *      @OA\MediaType(
    *          mediaType="application/json",
    *          @OA\Schema(ref="#/components/schemas/CompetitionRivalTeamRequest")
    *      )
    *  ),
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
     * Endpoint to create competition rival teams on bulk
     * @param CompetitionRivalTeamRequest $request
     * @return JsonResponse
     */
    public function storeBulk(CompetitionRivalTeamRequest $request)
    {
        $response = [];

        foreach($request->rival_teams as $rival_team) {
            $rival_team['competition_id'] = $request->competition_id;
            
            $rivalTeam = $this->rivalTeamService->store($rival_team, Auth::user());

            $response[] = $rivalTeam->makeHidden('competition');
        } 

        return $this->sendResponse($response, $this->translator('rival_team_created'), Response::HTTP_CREATED);
    }

    /**
    *  @OA\Put(
    *  path="/api/v1/competitions/rival-teams/bulk",
    *  tags={"Competitions"},
    *  summary="Competition rival teams match update - Actualiza equipos rivales de partidos de competicion",
    *  operationId="competitions-match-rival-team-update",
    *  description="Competition rival teams match update - Actualiza equipos rivales de partidos de competicion",
    *  security={{"bearerAuth": {} }},
    *  @OA\Parameter( ref="#/components/parameters/_locale" ),
    *  @OA\RequestBody(
    *      required=true,
    *      @OA\MediaType(
    *          mediaType="application/json",
    *          @OA\Schema(ref="#/components/schemas/UpdateCompetitionRivalTeamRequest")
    *      )
    *  ),
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
     * Endpoint to create competition rival teams on bulk
     * @param CompetitionRivalTeamRequest $request
     * @return JsonResponse
     */
    public function updateBulk(UpdateCompetitionRivalTeamRequest $request)
    {
        foreach ($request->rival_teams as $rival_team) {
            $data = [
                'rival_team' => $rival_team['name']
            ];

            if(isset($rival_team['image'])) { $data['image'] = $rival_team['image']; }

            $this->rivalTeamService->update($rival_team['id'], $data);
        }

        return $this->sendResponse(null, 'Rival Teams updated!');
    }
}
