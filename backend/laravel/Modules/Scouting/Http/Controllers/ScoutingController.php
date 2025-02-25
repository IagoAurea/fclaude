<?php

namespace Modules\Scouting\Http\Controllers;

use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Services\Interfaces\ScoutingStatusServiceInterface;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Scouting\Exceptions\ScoutingAlreadyFinishedException;
use Modules\Scouting\Exceptions\ScoutingAlreadyStartedException;
use Modules\Scouting\Exceptions\ScoutingHasNotStartedException;
use Modules\Scouting\Exceptions\ScoutingAlreadyPausedException;
use Modules\Scouting\Exceptions\ScoutingFinishedException;
use Modules\Scouting\Http\Resources\ScoutingListResource;
use Modules\Scouting\Http\Requests\ScoutingUpdateRequest;
use Modules\Scouting\Http\Requests\ScoutingFinishRequest;
use Modules\Scouting\Exceptions\ScoutingPausedException;
use Modules\Scouting\Http\Requests\ScoutingPauseRequest;
use Modules\Player\Services\LineupPlayerTypeService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;
use Illuminate\Http\Request;
use Exception;

class ScoutingController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * 
     * @var $scoutingRepository
     */
    protected $scoutingRepository;

    /**
     * Service
     * 
     * @var $scoutingStatusService
     */
    protected $scoutingStatusService;

    /**
     * @var object $lineupPlayerTypeService
     */
    protected $lineupPlayerTypeService;

    /**
     * Instances a new controller class
     * 
     * @param ScoutingRepositoryInterface $scoutingRepository
     * @param ScoutingStatusServiceInterface $scoutingStatusService
     */
    public function __construct(
        ScoutingRepositoryInterface $scoutingRepository,
        ScoutingStatusServiceInterface $scoutingStatusService,
        LineupPlayerTypeService $lineupPlayerTypeService
    ) {
        $this->scoutingRepository = $scoutingRepository;
        $this->scoutingStatusService = $scoutingStatusService;
        $this->lineupPlayerTypeService = $lineupPlayerTypeService;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/available/{team_id}",
     *       tags={"Scouting"},
     *       summary="List of availables scouting grouped by team - Listado de partidos a scoutear por equipo",
     *       operationId="scouting-available",
     *       description="Display a list of availables scouting grouped by team - Muestra un listado de partidos a scoutear por equipo",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Parameter( ref="#/components/parameters/timezone" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a list of the next games
     * availables to scout by team
     * 
     * @param int $team_id
     * @param Request $request
     * @return Response
     */
    public function index($team_id, Request $request)
    {
        $params = $request->only([
            'orderByDate',
            'orderByCompetition',
            'filterByDate',
            'filterByCompetition',
            'history',
            'timezone'
        ]);

        $nextMatches = $this
            ->scoutingRepository
            ->findAllNextMatchesToScoutByTeam($team_id, $params);

        $payload = ScoutingListResource::collection($nextMatches);

        return $this->sendResponse($payload, 'List of games to scout');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{competition_match_id}/status",
     *       tags={"Scouting"},
     *       summary="Status of a competition match scouting - Status de un scouting de un partido",
     *       operationId="scouting-status",
     *       description="Status of a competition match scouting - Status de un scouting de un partido",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display the status of a scouting
     * by a gvien competition match id
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function show($competition_match_id)
    {
        $payload = $this->scoutingRepository
            ->findOrCreateScout($competition_match_id);
            
        $payload->competitionMatch;
        $payload->competitionMatch->competition->team ?? NULL;
        $payload->competitionMatch->competition->team->sport->court ?? NULL;
        $payload->competitionMatch->competitionRivalTeam;
        $payload->competitionMatch->weather;
        $payload->competitionMatch->referee;
        $payload->competitionMatch->rivals;
        $payload->competitionMatch->players;
        $payload->competitionMatch->test_category;
        $payload->competitionMatch->test_type_category;
        $payload->competitionMatch->modality;
        $payload->competitionMatch->lineup;

        $sport_code = $payload->competitionMatch->competition->team->sport->code ?? NULL;

        if($sport_code) {
            $payload->competitionMatch->lineup_player = $this->lineupPlayerTypeService->getLineupPlayerType($sport_code);
        }

        return $this->sendResponse($payload, 'Scouting status');
    }

    /**
    *  @OA\Put(
    *  path="/api/v1/scouting/{scouting_id}",
    *  tags={"Scouting"},
    *  summary="Scouting update fields scouting - Actualiza un scouting",
    *  operationId="scouting-update",
    *  description="Scouting update - Actualiza un scouting",
    *  security={{"bearerAuth": {} }},
    *  @OA\Parameter( ref="#/components/parameters/_locale" ),
    *  @OA\Parameter( ref="#/components/parameters/scouting_id" ),
    *  @OA\RequestBody(
    *      required=true,
    *      @OA\JsonContent(
    *          ref="#/components/schemas/ScoutingUpdateRequest"
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
     *
     * @param ScoutingUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update($id, ScoutingUpdateRequest $request)
    {
        $scouting = $this->scoutingRepository->find($id);

        if (!$scouting) {
            return $this->sendError('Scouting not found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND);
        }

        try {
            $dataUpdate = $request->except('sets');

            if($request->sets) {
                $dataUpdate['custom_params'] = json_encode([
                    'sets' => $request->sets
                ]);
            }

            $scoutingUpdate = $this->scoutingRepository->update($dataUpdate, ["id" => $id]);

            return $this->sendResponse($scoutingUpdate, 'Scouting updated!');
        } catch (Exception $exception) {
            return $this->sendError('An error has occurred', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/scouting/{competition_match_id}/start",
     *       tags={"Scouting"},
     *       summary="Start a scouting for a competition match",
     *       operationId="scouting-start",
     *       description="Start a scouting for a competition match",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Start a scouting for a competition match
     *
     * @param int $competition_match_id
     * @return Response
     */
    public function startScouting($competition_match_id)
    {
        try {
            $response = $this->scoutingStatusService->start($competition_match_id);
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(
                $this->translator('competition_match_not_found', ['competition_id' => $competition_match_id])
            );
        } catch (ScoutingAlreadyStartedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_started', ['match_id' =>  $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (ScoutingFinishedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_finished', ['match_id' =>  $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($response, $this->translator('scouting_start_message'));
    }

    /**
     * @OA\Post(
     *       path="/api/v1/scouting/{competition_match_id}/pause",
     *       tags={"Scouting"},
     *       summary="Pause a scouting for a competition match",
     *       operationId="scouting-pause",
     *       description="Pause a scouting for a competition match",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Parameter( ref="#/components/parameters/in_game_time" ),
     *       @OA\Parameter( ref="#/components/parameters/in_period_time" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Pause a scouting for a competition match
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function pauseScouting($competition_match_id, ScoutingPauseRequest $request)
    {
        try {
            $response = $this->scoutingStatusService->pause($competition_match_id, $request->validated());
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(
                sprintf('The competition match %s does not exist', $competition_match_id)
            );
        } catch (ScoutingHasNotStartedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_not_started', ['match_id' =>  $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (ScoutingAlreadyPausedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_paused', ['match_id' => $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (ScoutingFinishedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_finished', ['match_id' => $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($response, $this->translator('scouting_paused_message'));
    }

    /**
     * @OA\Post(
     *       path="/api/v1/scouting/{competition_match_id}/finish",
     *       tags={"Scouting"},
     *       summary="Finish a scouting for a competition match",
     *       operationId="scouting-finish",
     *       description="Finish a scouting for a competition match",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Finish a scouting for a competition match
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function finishScouting($competition_match_id, ScoutingFinishRequest $request)
    {
        try {
            $response = $this->scoutingStatusService->finish($competition_match_id, $request->validated());
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(
                $this->translator('competition_match_not_found', ['competition_id' => $competition_match_id])
            );
        } catch (ScoutingHasNotStartedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_not_started', ['match_id' => $competition_match_id]),

                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (ScoutingPausedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_paused', ['match_id' => $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (ScoutingAlreadyFinishedException $exception) {
            return $this->sendError(
                $this->translator('competition_match_finished', ['match_id' => $competition_match_id]),
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($response, $this->translator('scouting_finished_message'));
    }
}
