<?php

namespace Modules\Scouting\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\Scouting\Exceptions\SportNotSupportedException;
use Modules\Scouting\Http\Requests\ScoutingResultStoreRequest;
use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Scouting\Processors\Interfaces\ResultsProcessorInterface;
use Modules\Scouting\Services\Interfaces\ScoutingResultServiceInterface;
use Modules\Scouting\Services\Interfaces\ScoutingStatusServiceInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingActivityRepositoryInterface;

class ScoutingResultsController extends BaseController
{
    use TranslationTrait;
    
    /**
     * Repository
     * @var $scoutingRepository
     */
    protected $scoutingRepository;
    
    /**
     * Repository
     * @var $scoutingResultRepository
     */
    protected $scoutingResultRepository;

    /**
     * Service
     * @var $scoutingStatusService
     */
    protected $scoutingStatusService;
    
    /**
     * Service
     * @var $scoutingResultService
     */
    protected $scoutingResultService;

    /**
     * Repository
     * @var $scoutingActivityRepository
     */
    protected $scoutingActivityRepository;

    /**
     * Repository
     * @var $sportRepository
     */
    protected $sportRepository;
    
    /**
     * Processor
     * @var $resultsProcessor
     */
    protected $resultsProcessor;
    
    /**
     * ScoutingController constructor.
     * @param ScoutingStatusServiceInterface $scoutingStatusService
     * @param ScoutingResultServiceInterface $scoutingResultService
     * @param ScoutingRepositoryInterface $scoutingRepository
     * @param ScoutingActivityRepositoryInterface $scoutingActivityRepository
     * @param ScoutingResultRepositoryInterface $scoutingResultRepository
     * @param SportRepositoryInterface $sportRepository
     * @param ResultsProcessorInterface $resultsProcessor
     */
    public function __construct(
        ScoutingStatusServiceInterface $scoutingStatusService,
        ScoutingResultServiceInterface $scoutingResultService,
        ScoutingRepositoryInterface $scoutingRepository,
        ScoutingActivityRepositoryInterface $scoutingActivityRepository,
        ScoutingResultRepositoryInterface $scoutingResultRepository,
        SportRepositoryInterface $sportRepository,
        ResultsProcessorInterface $resultsProcessor
    ) {
        $this->scoutingStatusService = $scoutingStatusService;
        $this->scoutingResultService = $scoutingResultService;
        $this->scoutingRepository = $scoutingRepository;
        $this->scoutingActivityRepository = $scoutingActivityRepository;
        $this->scoutingResultRepository = $scoutingResultRepository;
        $this->sportRepository = $sportRepository;
        $this->resultsProcessor = $resultsProcessor;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{competition_match_id}/results",
     *       tags={"Scouting Results"},
     *       summary="It process the scouting activities associated to the given competition match and returns the results of the scouting",
     *       operationId="scouting-results",
     *       description="It process the scouting activities associated to the given competition match and returns the results of the scouting",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Parameter( ref="#/components/parameters/all_statistics" ),
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
     * It process the scouting activities associated
     * to the given competition match and returns
     * the results of the scouting
     *
     * @param int $competition_match_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($competition_match_id, Request $request)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);

            $results = $this->scoutingResultRepository->findOneBy([
                'scouting_id' => $scouting->id
            ]);

            $allStatistics = $request->all_statistics === 'true' ?? true;

            if ($results) {
                $response = $results->data;
                $response->in_game_time = $results->in_game_time;

                if(isset($response->statistics)) {
                    $response->statistics = $this->scoutingResultService->convertStatistics(
                        $response->statistics, $competition_match_id, $allStatistics);
                }
            } else {
                $response = $this->resultsProcessor->match($competition_match_id, $allStatistics);
                
                if(isset($response['statistics'])) {
                    $response['statistics'] = $this->scoutingResultService->convertStatistics(
                        $response['statistics'], $competition_match_id, $allStatistics);
                }
            }
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError($this->translator('competition_match_not_found', ['competition_id' => $competition_match_id]));
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf($this->translator('scouting_not_sport_config'), $exception->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (MatchAlreadyHasAWinnerException $exception) {
            return $this->sendError($this->translator('scouting_already_has_winner'), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('scouting_search_error'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->sendResponse($response, sprintf('Scouting results for match %s', $competition_match_id));
    }

    /**
     * @OA\Post(
     *       path="/api/v1/scouting/{competition_match_id}/results",
     *       tags={"Scouting Results"},
     *       summary="It stores the results of the scouting",
     *       operationId="scouting-results-store",
     *       description="It stores the results of the scouting",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(ref="#/components/schemas/ScoutingResultStoreRequest")
     *         )
     *       ),
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
     * It stores the results of the scouting
     *
     * @param int $competition_match_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScoutingResultStoreRequest $request, $competition_match_id)
    {
        $scouting = $this->scoutingRepository
            ->findOrCreateScout($competition_match_id);

        $result = $this->scoutingResultRepository->findOneBy([
                'scouting_id' => $scouting->id
            ]);

        if (!$result) {
            $result = $this->scoutingResultRepository->create([
                    'scouting_id' => $scouting->id,
                    'in_game_time' => $request->in_game_time,
                    'data' => json_encode($request->scouting),
                ]);
        } else {
            $result->update([
                'in_game_time' => $request->in_game_time,
                'data' => json_encode($request->scouting),
            ]);
        }

        return $this->sendResponse($result, $this->translator('scouting_results_store'));
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{competition_match_id}/player/{player_id}/actions",
     *       tags={"Scouting Results"},
     *       summary="It returns the actions associated to a player",
     *       operationId="scouting-player-actions",
     *       description="It returns the actions associated to a player",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * It returns the actions associated to a player
     *
     * @param int $competition_match_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPlayerActions($competition_match_id, $player_id)
    {
        try {
            $results = $this->resultsProcessor->playerMatchActions($competition_match_id, $player_id);
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(sprintf('The competition match %s does not exist', $competition_match_id));
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf(
                    'The sport of this scouting (%s) has not being configured to process the scouting activities associated',
                    $exception->getMessage()
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($results, sprintf('Player activities for match %s', $competition_match_id));
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{competition_match_id}/player/{player_id}/results",
     *       tags={"Scouting Results"},
     *       summary="It returns the results of scouting for the actions associated to a player",
     *       operationId="scouting-player-results",
     *       description="It returns the results of scouting for the actions associated to a player",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * It returns the results of scouting for
     * the actions associated to a player
     * 
     * @param int $competition_match_id
     * @param int $player_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPlayerResults($competition_match_id, $player_id)
    {
        try {
            $results = $this->resultsProcessor->playerMatchResults($competition_match_id, $player_id);

            $results['statistics'] = $this->scoutingResultService->
                convertStatistics($results['statistics'], $competition_match_id, true, true);

        } catch (CompetitionMatchNotFoundException $exception) {
            
            return $this->sendError($this->translator('competition_match_not_found', ['competition_id' => $competition_match_id]));
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf(
                    'The sport of this scouting (%s) has not being configured to process the scouting activities associated',
                    $exception->getMessage()
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($results, sprintf('Player activities for match %s', $competition_match_id));
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/player/{player_id}/latest-actions",
     *       tags={"Scouting Results"},
     *       summary="It returns the latest actions associated to a player",
     *       operationId="scouting-player-latest-actions",
     *       description="It returns the latest actions associated to a player",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * It process the scouting activities associated
     * to the given competition match and returns
     * the results of the scouting
     * 
     * @param int $competition_match_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showLatestPlayerActions($player_id)
    {
        try {
            $scouting_activity = $this->scoutingActivityRepository->latestPlayerScouting($player_id);
            $competition_match_id = $scouting_activity->scouting->competition_match_id;
            $results = $this->resultsProcessor->playerMatchActions($competition_match_id, $player_id);
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError($this->translator('competition_match_not_found', ['competition_id' => $competition_match_id]));
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf(
                    'The sport of this scouting (%s) has not being configured to process the scouting activities associated',
                    $exception->getMessage()
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($results, sprintf('Player activities for match %s', $competition_match_id));
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{competition_match_id}/player/actions",
     *       tags={"Scouting Results"},
     *       summary="Actions of a competition match, grouped by players",
     *       operationId="scouting-player-latest-actions",
     *       description="Actions of a competition match, grouped by players",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * Actions of a competition match, grouped by players
     * 
     * @param int $competition_match_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPlayerActions($competition_match_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOneBy(['competition_match_id' => $competition_match_id]);
            $results = $this->scoutingActivityRepository->getMatchActivitiesGroupedByPlayers($scouting->id);
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError($this->translator('competition_match_not_found', ['competition_id' => $competition_match_id]));
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf(
                    'The sport of this scouting (%s) has not being configured to process the scouting activities associated',
                    $exception->getMessage()
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->sendResponse($results, sprintf('Player activities for match %s grouped by players', $competition_match_id));
    }

    /**
     * @OA\Get(
     *       path="/api/v1/scouting/{sport_code}/side_effects",
     *       tags={"Scouting Results"},
     *       summary="Returns the list of side effects associated to the given sport, using the sport code as the needle for the search",
     *       operationId="scouting-side-effects",
     *       description="Returns the list of side effects associated to the given sport, using the sport code as the needle for the search",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
     * Returns the list of side effects associated
     * to the given sport, using the sport code
     * as the needle for the search
     * 
     * @param string $sport_code
     * @throws \Modules\Scouting\Exceptions\SportNotSupportedException
     * @return \Illuminate\Http\JsonResponse
     */
    public function sideEffects($sport_code)
    {
        $sport_codes = $this->sportRepository->getSportCodes();

        if (!$sport_codes->contains($sport_code)) {
            return $this->sendError($this->translator('sport_code_not_found', ['sport_code' => $sport_code]));
        }

        try {
            $side_effects = $this->getSideEffects($sport_code);
        } catch (SportNotSupportedException $exception) {
            return $this->sendError(
                sprintf(
                    'The sport of this scouting (%s) has not being configured to process the scouting activities associated',
                    $exception->getMessage()
                ),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $sport = $this->sportRepository->findBy(['code' => $sport_code])->first();

        return $this->sendResponse($side_effects, sprintf('List of side effects for sport %s', $sport->code));
    }

    /**
     * Returns the list of side effects associated
     * to the given sport, using the sport code
     * as the needle for the search on
     * the configuration object
     * 
     * @param string $sport_code
     * @throws \Modules\Scouting\Exceptions\SportNotSupportedException
     * @return array
     */
    private function getSideEffects($sport_code)
    {
        if (!isset(config('scouting.side_effects')[$sport_code])) {
            throw new SportNotSupportedException($sport_code);
        }
        return config('scouting.side_effects')[$sport_code];
    }
}
