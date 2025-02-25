<?php


namespace Modules\Competition\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Modules\Activity\Events\ActivityEvent;
use Modules\Generality\Services\ResourceService;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Competition\Http\Requests\CompetitionRivalTeamRequest;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;

class CompetitionService
{
    use ResourceTrait, TranslationTrait;

    /**
     * Resource Repository
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Resource Service
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * Competition Repository
     * @var $competitionRepository
     */
    protected $competitionRepository;
    
    /**
     * Team Repository
     * @var $teamRepository
     */
    protected $teamRepository;
    
    /**
     * CompetitionMatchPlayer Repository
     * @var $competitionMatchPlayerRepository
     */
    protected $competitionMatchPlayerRepository;

    /**
     * CompetitionService constructor.
     * @param ResourceRepositoryInterface $resourceRepository
     * @param ResourceService $resourceService
     * @param CompetitionMatchPlayerRepositoryInterface $competitionMatchPlayerRepository
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(ResourceRepositoryInterface $resourceRepository,
                                ResourceService $resourceService,
                                TeamRepositoryInterface $teamRepository,
                                CompetitionRepositoryInterface $competitionRepository,
                                CompetitionMatchPlayerRepositoryInterface $competitionMatchPlayerRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
        $this->teamRepository = $teamRepository;
        $this->competitionRepository = $competitionRepository;
        $this->competitionMatchPlayerRepository = $competitionMatchPlayerRepository;
    }

    /**
     * Process for creating bulk data
     * @param $data "data for creating"
     * @return array
     */
    public function createBulkMatchPlayers($data)
    {
        $created = [];
        foreach ($data as $value) {
            $saved = $this->competitionMatchPlayerRepository->create($value);
            $created[] = $saved;

            // event(
            //     new ActivityEvent(
            //         Auth::user(),
            //         $saved,
            //         'CompetitionMatchPlayer',
            //         'competition_match_player_created'
            //     )
            // );
        }
        return $created;
    }

    /**
     * Verify if exist matches competition of team by date
     * @param integer $team_id
     * @param $date
     * @return boolean
     */
    public function verifyMatchesCompetitionByDate($competition_id, $date)
    {
        $competition = $this->competitionRepository->findOneBy(['id' => $competition_id]);

        if (!$competition) { throw new Exception("Competition not found"); }
        
        if ($date < $competition->date_start || $date > $competition->date_end) {
            abort(response()->error($this->translator('date_out_range'), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        $team = $this->teamRepository->findTeamById($competition->team_id);

        $sport = $team->sport;
        
        foreach($competition->matches as $match) {
            $dateStartMatch = $match->start_at;

            $dateEndMatch = Carbon::createFromTimeString($dateStartMatch)->add($sport->time_game, 'hour');

            $verify = Carbon::createFromTimeString($date)->between($dateStartMatch, $dateEndMatch);

            if ($verify) { return true; }
        }

        return false;
    }

}
