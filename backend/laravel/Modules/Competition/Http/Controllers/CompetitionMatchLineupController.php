<?php


namespace Modules\Competition\Http\Controllers;


use App\Http\Controllers\Rest\BaseController;
use \Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Events\ActivityEvent;
use Modules\Competition\Http\Requests\CompetitionMatchLineupRequest;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchLineupRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class CompetitionMatchLineupController extends BaseController
{

    /**
     * Repository
     * @var $competitionMatchLineupRepository
     */
    protected $competitionMatchLineupRepository;

    /**
     * Repository CompetitionMatch
     * @var $competitionMatchRepository
     */
    protected $competitionMatchRepository;

    /**
     * CompetitionMatchLineupController constructor.
     * @param CompetitionMatchLineupRepositoryInterface $competitionMatchLineupRepository
     * @param CompetitionMatchRepositoryInterface $competitionMatchRepository
     */
    public function __construct(CompetitionMatchLineupRepositoryInterface $competitionMatchLineupRepository,
                                CompetitionMatchRepositoryInterface $competitionMatchRepository)
    {
        $this->competitionMatchLineupRepository = $competitionMatchLineupRepository;
        $this->competitionMatchRepository = $competitionMatchRepository;
    }

    /**
     * List all competition match lineups
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->competitionMatchLineupRepository->findAll(),
            'List CompetitionMatchLineups');
    }

    /**
     * Endpoint to create a match lineup
     * @param CompetitionMatchLineupRequest $request
     * @return JsonResponse
     */
    public function store(CompetitionMatchLineupRequest $request)
    {
        try {
            $lineUp = $this->competitionMatchLineupRepository->create($request->all());

            event(
                new ActivityEvent(
                    Auth::user(),
                    $lineUp->competitionMatch->team->club,
                    'competition_match_lineup_created',
                    $lineUp->competitionMatch->team
                )
            );

            return $this->sendResponse($lineUp, "Match Lineup Created", Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError("An error has occurred", $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Last Match Lineup By Competition
     * @param $competition_id
     * @return JsonResponse
     */
    public function getLastMatchLineup($competition_id)
    {
        $id_last_competition_match = $this->competitionMatchRepository->findLastMatchByCompetition($competition_id);

        $criteria = ["competition_match_id" => $id_last_competition_match];
        return $this->sendResponse($this->competitionMatchLineupRepository
            ->findOneBy($criteria),
            "Last Match Lineup By Competition");
    }
}
