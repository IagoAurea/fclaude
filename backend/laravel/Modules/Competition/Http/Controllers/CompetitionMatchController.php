<?php

namespace Modules\Competition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Services\MatchService;
use Symfony\Component\HttpFoundation\Response;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Services\CompetitionService;
use Modules\Competition\Http\Requests\UpdateMatchRequest;
use Modules\Competition\Http\Requests\CompetitionMatchRequest;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class CompetitionMatchController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $competitionMatchRepository
     */
    protected $competitionMatchRepository;

    /**
     * @var $matchService
     */
    protected $matchService;

    /**
     * @var $competitionService
     */
    protected $competitionService;

    /**
     * Creates a new constructor instance
     */
    public function __construct(
        CompetitionMatchRepositoryInterface $competitionMatchRepository,
        MatchService $matchService,
        CompetitionService $competitionService
    ) {
        $this->competitionMatchRepository = $competitionMatchRepository;
        $this->matchService = $matchService;
        $this->competitionService = $competitionService;
    }

     /**
     * Retrieve all matches created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/competitions/matches/user",
     *  tags={"Competition/Match"},
     *  summary="List all matches of user authenticate - Lista todos los partidos creado por el usuario",
     *  operationId="list-matches-user",
     *  description="List all matches of user authenticate -
     *  Lista todos los partidos creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
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
    public function getAllMatchesUser()
    {
        $matches = $this->matchService->allMatchesByUser(Auth::id());

        return $this->sendResponse($matches, 'List all matches of user');
    }

    /**
     * Get All Matches
     * @return JsonResponse
     */
    public function index()
    {
        $matches = $this->matchService->list();

        return $this->sendResponse($matches, 'List all matches');
    }

    /**
     * Endpoint to create a match
     * @param CompetitionMatchRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *  path="/api/v1/competitions/matches/add",
     *  tags={"Competition/Match"},
     *  summary="Stores a new match item into the database",
     *  operationId="competition-match-store",
     *  description="Creates a new competition match item - Crea un item de partido o encuentro de competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CreateCompetitionMatchRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information about recently created match",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CompetitionMatchStoreResponse"
     *      )
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
    public function store(CompetitionMatchRequest $request)
    {
        $permission = Gate::inspect('store-competition-match', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $validate = $this->competitionService->verifyMatchesCompetitionByDate($request->competition_id, $request->start_at);

        if($validate) {
            return $this->sendError(
                $this->translator('date_match_not_available'), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $matchData = $request->except('lineup');
        
        $lineupData = $request->only('lineup') ?? [];

        $rivalsData = $request->rivals ?? [];

        $playersData = $request->players ?? [];

        $match = $this->matchService->store($matchData, $lineupData, $rivalsData, $playersData);

        return $this->sendResponse($match,
            $this->translator('competition_match_store_message'), Response::HTTP_CREATED);
    }

    /**
     * Shows a single match depending of the id used
     * @param CompetitionMatchRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/competitions/{team_id}/matches/{match_id}",
     *  tags={"Competition/Match"},
     *  summary="Shows a match item from database",
     *  operationId="competition-match-show",
     *  description="Shows an existent competition match item - Muestra informacion sobre un item de partido o encuentro de competicion",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/match_id"
     *   ),
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
    public function show(Team $team, CompetitionMatch $match)
    {
        $permission = Gate::inspect('read-competition-match', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $specifiedMatch = $this->matchService->get($match, $team->id);

        return $this->sendResponse($specifiedMatch, 'Match Information');
    }

    /**
     * Updates an specific match
     * @param UpdateMatchRequest $request
     * @return JsonResponse
     *
     * @OA\Put(
     *  path="/api/v1/competitions/{team_id}/matches/{match_id}",
     *  tags={"Competition/Match"},
     *  summary="Updates an existent match item from database",
     *  operationId="competition-match-update",
     *  description="Updates an existent competition match item - Actualiza un item de partido o encuentro de competicion existente",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/match_id"
     *   ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateMatchRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information about recently updated match",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CompetitionMatchUpdateResponse"
     *      )
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
    public function update(Team $team, CompetitionMatch $match, UpdateMatchRequest $request)
    {
        $permission = Gate::inspect('update-competition-match', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $matchData = $request->except('lineup');
        
        $lineupData = $request->only('lineup');
        
        $rivalsData = $request->rivals ?? [];

        $playersData = $request->players ?? [];
        
        try {
            $updated = $this->matchService->update(
                $match,
                $matchData,
                $lineupData,
                $rivalsData,
                $playersData
            );

            return $this->sendResponse($updated,
                $this->translator('competition_match_update_message'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('An error has ocurred updating the match', $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Endpoint to get next matches by team
     * @param $team_id
     * @return JsonResponse
     */
    public function nextMatches($team_id)
    {
        return $this->sendResponse(
            $this->competitionMatchRepository->findAllNextMatchesByTeamId($team_id),
            "List next matches by team");
    }

    /**
     * Shows a competition with matches divisiton list
     * @param CompetitionMatchRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/competitions/{competition_id}/matches",
     *  tags={"Competition/Match"},
     *  summary="Shows a match item from database",
     *  operationId="competition-list-general-matches",
     *  description="Shows information about competition and list all matches",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *   @OA\Parameter(
     *      ref="#/components/parameters/competition_id"
     *   ),
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
    public function listMatches(Request $request, Competition $competition)
    {
        try {
            $matches = $this->matchService->generalList($request->all(), $competition);
            return $this->sendResponse($matches, 'Competition Matches');
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    /**
     * Endpoint to get recent matches by team
     * @param $team_id
     * @return JsonResponse
     *
     *  @OA\Get(
     *  path="/api/v1/competitions/matches/recent/team/{team_id}",
     *  tags={"Competition/Match"},
     *  summary="Shows recent matches by team",
     *  operationId="competition-list-matches-team",
     *  description="Shows information about competition and list all matches by team",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(ref="#/components/parameters/_locale"),
     *   @OA\Parameter(ref="#/components/parameters/team_id"),
     *   @OA\Response(
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
    public function recentMatchesByTeam($team_id)
    {
        $matches = $this->matchService->allRecentMatchesByTeam($team_id);

        return $this->sendResponse($matches, "List recent matches by team");
    }

    /**
     * Endpoint to get matches by competition
     * @param $competition_id
     * @return JsonResponse
     *
     */
    public function getByCompetition($competition_id)
    {
        return $this->sendResponse($this->competitionMatchRepository->findAllByCompetition($competition_id),
            "List matches by competition");
    }

    /**
     * Endpoint to get recent matches general
     * @return JsonResponse
     *
     *  @OA\Get(
     *  path="/api/v1/competitions/matches/recent",
     *  tags={"Competition/Match"},
     *  summary="Shows matches recent",
     *  operationId="competition-list-matches-recent",
     *  description="Shows information about competition and list all matches recent",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(ref="#/components/parameters/_locale"),
     *   @OA\Response(
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
    public function recentMatches()
    {
        //TODO: Agregar usuario que comparte clubs
        $users = [
            Auth::id()
        ];

        $recentMatches = $this->matchService->findAllRecentMatches($users);

        return $this->sendResponse($recentMatches, "List recent matches");
    }

}
