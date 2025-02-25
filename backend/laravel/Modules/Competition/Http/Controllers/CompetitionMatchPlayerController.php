<?php


namespace Modules\Competition\Http\Controllers;


use \Exception;
use App\Traits\TranslationTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Competition\Services\CompetitionService;
use Modules\Competition\Http\Requests\PerceptEffortPlayerRequest;
use Modules\Competition\Http\Requests\CompetitionMatchPlayerRequest;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class CompetitionMatchPlayerController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * @var $competitionMatchPlayerRepository
     */
    protected $competitionMatchPlayerRepository;

    /**
     * Service of competition
     * @var $competitionService
     */
    protected $competitionService;

    /**
     * CompetitionMatch Repository
     * @var $competitionMatchRepository
     */
    protected $competitionMatchRepository;

    /**
     * CompetitionMatchPlayerController constructor.
     * @param CompetitionMatchPlayerRepositoryInterface $competitionMatchPlayerRepository
     * @param CompetitionService $competitionService
     * @param CompetitionMatchRepositoryInterface $competitionMatchRepository
     */
    public function __construct(
        CompetitionMatchPlayerRepositoryInterface $competitionMatchPlayerRepository,
        CompetitionService $competitionService,
        CompetitionMatchRepositoryInterface $competitionMatchRepository
    ) {
        $this->competitionMatchPlayerRepository = $competitionMatchPlayerRepository;
        $this->competitionService = $competitionService;
        $this->competitionMatchRepository = $competitionMatchRepository;
    }

    /**
     * Endpoint to create match players as bulk way
     * @param CompetitionMatchPlayerRequest $request
     * @return JsonResponse
     */
    public function storeBulk(CompetitionMatchPlayerRequest $request)
    {
        try {
            $data = (array) $request->players;
            $response = $this->competitionService->createBulkMatchPlayers($data);
            if (count($response) === 0)
                return $this->sendError(
                    "There are no data for creating",
                    "ERROR",
                    Response::HTTP_BAD_REQUEST
                );

            return $this->sendResponse($response,   "List match players created", Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError(
                "An error has occurred",
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Endpoint to get last match players by competition
     * @param $competition_id
     * @return JsonResponse
     */
    public function getLastMatchPlayersByCompetition($competition_id)
    {
        $id_last_competition_match = $this->competitionMatchRepository->findLastMatchByCompetition($competition_id);

        $criteria = ["competition_match_id" => $id_last_competition_match];

        return $this->sendResponse(
            $this->competitionMatchPlayerRepository
                ->findBy($criteria),
            "List Last Match Players By Competition"
        );
    }

    /**
     * Store percept effort player match
     * 
     * @OA\Post(
     *  path="/api/v1/competitions/matches/competition/{competition_match_id}/percept_effort",
     *  tags={"Competition/Match"},
     *  summary="Add/Update percept effort to match player",
     *  operationId="competition-match-percept-effort",
     *  description="Add/Update percept effort to competition match player - Crea/Actualizar el esfuerzo de percepcion de un partido de competicion a jugador",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/competition_match_id"),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/PerceptEffortPlayerRequest"
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
    public function perceptEffortPlayer(PerceptEffortPlayerRequest $request, $competition_id)
    {
        try {
            $percept_effort = $this->competitionMatchPlayerRepository->update([
                'perception_effort_id' => $request->perception_effort_id
            ], [
                'competition_match_id' => $competition_id,
                'player_id' => $request->player_id
            ]);

            return $this->sendResponse($percept_effort, $this->translator('percept_effort_store_message'));
        } catch (Exception $exception) {
            return $this->sendError('Error by assign percept effort', $exception->getMessage());
        }

    }
}
