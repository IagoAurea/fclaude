<?php

namespace Modules\Competition\Services;

use Exception;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Club\Entities\ClubType;
use Illuminate\Support\Facades\Auth;
use Modules\Club\Services\ClubService;
use Modules\Activity\Events\ActivityEvent;
use Illuminate\Database\Eloquent\Collection;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Services\CompetitionService;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRivalRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchLineupRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;

class MatchService
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var object $matchRepository
     */
    protected $matchRepository;

    /**
     * @var object $matchLineupRepository
     */
    protected $matchLineupRepository;

    /**
     * @var object $matchPlayerRepository
     */
    protected $matchPlayerRepository;

    /**
     * @var object $matchRivalRepository
     */
    protected $matchRivalRepository;

    /**
     * @var object $competitionRepository
     */
    protected $competitionRepository;

    /**
     * Repository
     * @var $scoutingResultRepository
     */
    protected $scoutingResultRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var object $competitionService
     */
    protected $competitionService;

    /**
     * @var object $competitionService
     */
    protected $clubService;

    /**
     * @var object $helper
     */
    protected $helper;

    /**
     * Creates a new service instance
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        CompetitionMatchRepositoryInterface $matchRepository,
        CompetitionMatchLineupRepositoryInterface $matchLineupRepository,
        CompetitionMatchPlayerRepositoryInterface $matchPlayerRepository,
        CompetitionMatchRivalRepositoryInterface $matchRivalRepository,
        ScoutingResultRepositoryInterface $scoutingResultRepository,
        UserRepositoryInterface $userRepository,
        ClubRepositoryInterface $clubRepository,
        CompetitionService $competitionService,
        ClubService $clubService,
        Helper $helper
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->matchRepository = $matchRepository;
        $this->matchLineupRepository = $matchLineupRepository;
        $this->matchPlayerRepository = $matchPlayerRepository;
        $this->matchRivalRepository = $matchRivalRepository;
        $this->scoutingResultRepository = $scoutingResultRepository;
        $this->userRepository = $userRepository;
        $this->clubRepository = $clubRepository;
        $this->competitionService = $competitionService;
        $this->clubService = $clubService;
        $this->helper = $helper;
    }

    public function allMatchesByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_matches = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                $team->makeHidden(['players']);
                return $team->competitions->map(function ($competition) {
                    $competition->makeHidden('typeCompetition');
                    return $competition->matches->map(function ($match) {
                        $match->makeHidden(['competition', 'competitionRivalTeam']);
                    })->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_matches' => $total_matches ?? 0
        ];
    }

    /**
     * List a set of matches users by access club
     *
     * @return array
     */
    public function findAllRecentMatches($users)
    {
        $clubsUsers = $this->clubService->listClubsUsers($users);

        foreach ($clubsUsers as $club) {
            $teams = $club['teams'];

            $matchesRecent = new Collection();

            foreach ($teams as $team) {
                $matches = $this->matchRepository->findAllRecentMatchesByTeamId($team['id']);

                if (count($matches) === 0) {
                    continue;
                }

                foreach ($matches as $match) {
                    $match = $this->getScoreByMatch($match);
                }

                $matchesRecent = $matchesRecent->merge($matches);
            }

            $club['recent_matched'] = $matchesRecent;

            unset($club['teams']);
        }

        return $clubsUsers;
    }

    /**
     * List a set of matches by team
     *
     * @return array
     */
    public function allRecentMatchesByTeam($team_id)
    {
        $matches = $this->matchRepository->findAllRecentMatchesByTeamId($team_id);

        foreach ($matches as $match) {
            $match = $this->getScoreByMatch($match);
        }

        return $matches;
    }

    /**
     * List a set of matches
     *
     * @return array
     */
    public function list()
    {
        try {
            return $this->matchRepository->findAll();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a list of matches related to a competition
     *
     * @OA\Schema(
     *  schema="CompetitionGeneralMatchListResponse",
     *  type="object",
     *  description="Returns a competitio with details and match information",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Competition Matches"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", format="int64", example="1"),
     *      @OA\Property(property="team_id", format="int64", example="1"),
     *      @OA\Property(property="type_competition_id", format="int64", example="1"),
     *      @OA\Property(property="image_id", format="int64", example="1"),
     *      @OA\Property(property="date_start", format="date-time", example="2022-01-01 00:00:00"),
     *      @OA\Property(property="date_end", format="date-time", example="2022-01-01 00:00:00"),
     *      @OA\Property(property="state", format="int64", example="1"),
     *      @OA\Property(
     *          property="match_list",
     *          type="object",
     *          @OA\Property(
     *              property="recent",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", format="int64", example="1"),
     *                  @OA\Property(property="competition_id", format="int64", example="1"),
     *                  @OA\Property(property="competition_rival_team_id", format="int64", example="1"),
     *                  @OA\Property(property="referee_id", format="int64", example="1"),
     *                  @OA\Property(property="weather_id", format="int64", example="1"),
     *                  @OA\Property(property="match_situation", format="string", example="V"),
     *                  @OA\Property(property="competition_url_image", format="string", example="string"),
     *                  @OA\Property(property="competition_name", format="string", example="string"),
     *                  @OA\Property(property="location", format="string", example="string"),
     *                  @OA\Property(property="start_at", format="date-time", example="2022-01-01 00:00:00"),
     *                  @OA\Property(
     *                      property="competition_rival_team",
     *                      type="object",
     *                      @OA\Property(property="id", format="int64", example="1"),
     *                      @OA\Property(property="competition_id", format="int64", example="1"),
     *                      @OA\Property(property="image_id", format="int64", example="1"),
     *                      @OA\Property(property="rival_team", format="string", example="string"),
     *                      @OA\Property(property="url_image", format="string", example="string"),
     *                  ),
     *                  @OA\Property(
     *                      property="referee",
     *                      type="object",
     *                      @OA\Property(property="id", format="int64", example="1"),
     *                      @OA\Property(property="country_id", format="int64", example="1"),
     *                      @OA\Property(property="province_id", format="int64", example="1"),
     *                      @OA\Property(property="sport_id", format="int64", example="1"),
     *                      @OA\Property(property="name", format="string", example="string"),
     *                  ),
     *                  @OA\Property(
     *                      property="weather",
     *                      type="object",
     *                      @OA\Property(property="id", format="int64", example="1"),
     *                      @OA\Property(property="code", format="string", example="1"),
     *                      @OA\Property(property="name", format="string", example="1"),
     *                  ),
     *              ),
     *          ),
     *          @OA\Property(
     *              property="next",
     *              type="string",
     *              example="Same object structure as [recent] key"
     *          ),
     *      )
     *  ),
     * )
     */
    public function generalList($requestData, Competition $competition)
    {
        $competition->team;

        $competition->match_list = [
            'recent' => $competition->matches->where('start_at', '<', Carbon::now()),
            'next' => $competition->matches->where('start_at', '>=', Carbon::now()),
        ];

        return $competition;
    }

    /**
     * Inserts a new match into the database
     * @return object
     *
     * @OA\Schema(
     *  schema="CompetitionMatchStoreResponse",
     *  type="object",
     *  description="Returns the list of all injury prevention related players",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Match created"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", format="int64", example="1"),
     *      @OA\Property(property="competition_id", format="int64", example="1"),
     *      @OA\Property(property="start_at", format="date", example="2022-02-14"),
     *      @OA\Property(property="location", format="string"),
     *      @OA\Property(property="lane", format="string"),
     *      @OA\Property(property="competition_rival_team_id", format="int64", example="1"),
     *      @OA\Property(property="match_situation", format="string", example="L"),
     *      @OA\Property(property="referee_id", format="int64", example="1"),
     *      @OA\Property(property="weather_id", format="int64", example="1"),
     *      @OA\Property(property="test_category_match_id", format="int64", example="1"),
     *      @OA\Property(property="test_type_category_match_id", format="int64", example="1"),
     *      @OA\Property(property="competition_name", format="string"),
     *      @OA\Property(property="competition_url_image", format="string"),
     *  ),
     * )
     */
    public function store($matchData, $lineupData, $rivalsData, $playersData)
    {
        $competition = $this->competitionRepository->findOneBy(['id' => $matchData['competition_id']]);

        if ($matchData['start_at'] < $competition->date_start || $matchData['start_at'] > $competition->date_end) {
            abort(response()->error($this->translator('date_out_range'), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        try {
            $match = $this->matchRepository->create($matchData);

            if (Auth::user()) {
                event(
                    new ActivityEvent(
                        Auth::user(),
                        $match->competition->team->club,
                        'competition_match_created',
                        $match->competition->team,
                    )
                );
            }

            // Stores the match lineup
            if (count($lineupData) > 0) {
                if (isset($lineupData['lineup']['type_lineup_id'])) {
                    $this->matchLineupRepository->create([
                        'competition_match_id' => $match->id,
                        'type_lineup_id' => $lineupData['lineup']['type_lineup_id'],
                    ]);
                }

                // Loop through every lineup player and insert the relationship
                $this->insertMachPlayerRelations($match, $lineupData['lineup']['players']);
            }

            //Store rival player case swimming
            foreach ($rivalsData as $rival) {
                $this->matchRivalRepository->create([
                    'competition_match_id' => $match->id,
                    'rival_player' => $rival
                ]);
            }
            //Store player case swimming
            foreach ($playersData as $player) {
                $this->matchPlayerRepository->create([
                    'competition_match_id' => $match->id,
                    'player_id' => $player
                ]);
            }

            return $match;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves specific information about competition match
     * @return object
     *
     * @OA\Schema(
     *  schema="CompetitionMatchGetResponse",
     *  type="object",
     *  description="Returns information about match",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Match created"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", format="int64", example="1"),
     *      @OA\Property(property="competition_id", format="int64", example="1"),
     *      @OA\Property(property="start_at", format="date", example="2022-02-14"),
     *      @OA\Property(property="location", format="string"),
     *      @OA\Property(property="competition_rival_team_id", format="int64", example="1"),
     *      @OA\Property(property="match_situation", format="string", example="L"),
     *      @OA\Property(property="referee_id", format="int64", example="1"),
     *      @OA\Property(property="weather_id", format="int64", example="1"),
     *      @OA\Property(property="competition_name", format="string"),
     *      @OA\Property(property="competition_url_image", format="string"),
     *      @OA\Property(
     *          property="competition_rival_team",
     *          type="object",
     *          @OA\Property(property="id", format="int64", example="1"),
     *          @OA\Property(property="competition_id", format="int64", example="1"),
     *          @OA\Property(property="rival_team", format="string"),
     *          @OA\Property(property="image_id", format="int64", example="1"),
     *          @OA\Property(property="url_image", format="string"),
     *      ),
     *      @OA\Property(
     *          property="weather",
     *          type="object",
     *          @OA\Property(property="id", format="int64", example="1"),
     *          @OA\Property(property="code", format="string"),
     *          @OA\Property(property="name", format="string"),
     *      ),
     *      @OA\Property(
     *          property="referee",
     *          type="object",
     *          @OA\Property(property="id", format="int64", example="1"),
     *          @OA\Property(property="name", format="string"),
     *          @OA\Property(property="country_id", format="int64", example="1"),
     *          @OA\Property(property="province_id", format="int64", example="1"),
     *          @OA\Property(property="sport_id", format="int64", example="1"),
     *      ),
     *      @OA\Property(
     *          property="lineup",
     *          type="object",
     *          @OA\Property(property="id", format="int64", example="1"),
     *          @OA\Property(property="competition_match_id", format="int64", example="1"),
     *          @OA\Property(property="type_lineup_id", format="int64", example="1"),
     *          @OA\Property(
     *              property="type_lineup",
     *              type="object",
     *              @OA\Property(property="id", format="int64", example="1"),
     *              @OA\Property(property="sport_id", format="int64", example="1"),
     *              @OA\Property(property="modality_id", format="int64", example="1"),
     *              @OA\Property(property="lineup", format="string", example="1-2-4-1"),
     *              @OA\Property(property="total_players", format="int64", example="8"),
     *          ),
     *      )
     *  ),
     * )
     */
    public function get(CompetitionMatch $match, $teamId)
    {
        if ($match->competition->team_id !== $teamId) {
            abort(Response::HTTP_FORBIDDEN, @trans('competition::messages.policies.competition_match.show.deny'));
        }

        $match->scouting;
        $match->competitionRivalTeam;
        $match->weather;
        $match->referee;
        $match->lineup;
        $match->rivals;
        $match->competitionMatchRival;
        $match->test_category;
        $match->test_type_category;
        $match->players_match = $this->helper->sortArrayByKey($match->players->toArray(), "perception_effort_id", true);

        return $match;
    }

    /**
     * Retrieves specific information about competition match
     * @return object
     *
     * @OA\Schema(
     *  schema="CompetitionMatchUpdateResponse",
     *  type="object",
     *  description="Returns information about match update",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Match updated"),
     *  @OA\Property(
     *      property="data",
     *      type="boolean",
     *      example="true",
     *  ),
     * )
     */
    public function update(CompetitionMatch $match, $matchData, $lineupData, $rivalsData, $playersData)
    {
        try {
            $this->matchRepository->update($matchData, $match);

            if (isset($lineupData['lineup']['type_lineup_id'])) {
                $lineup = $this->matchLineupRepository->findOneBy([
                    'competition_match_id' => $match->id,
                    'type_lineup_id' => $match->lineup->type_lineup_id,
                ]);

                $this->matchLineupRepository->update([
                    'type_lineup_id' => $lineupData['lineup']['type_lineup_id']
                ], $lineup);
            }

            if (isset($lineupData['lineup']['players'])) {
                $this->insertMachPlayerRelations($match, $lineupData['lineup']['players']);
            }

            if ($rivalsData) {
                $this->addRivalsMatch($rivalsData, $match->id);
            }

            if ($playersData) {
                $this->addPlayersMatch($playersData, $match->id);
            }

            if (Auth::user()) {
                event(
                    new ActivityEvent(
                        Auth::user(),
                        $match->competition->team->club,
                        'competition_match_updated',
                        $match->competition->team
                    )
                );
            }

            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Insert match player relations by bulk
     * @return void
     */
    private function insertMachPlayerRelations($match, $matchPlayers)
    {
        // Delete all previous players related
        $this->matchPlayerRepository->deleteByCriteria([
            'competition_match_id' => $match->id,
        ]);

        // Loop through every lineup player and insert the relationship
        foreach ($matchPlayers as $lineupPlayer) {
            $dataLineUp = [
                'competition_match_id' => $match->id,
                'player_id' => $lineupPlayer['player_id'],
            ];

            if (isset($lineupPlayer['lineup_player_type_id'])) {
                $dataLineUp['lineup_player_type_id'] = $lineupPlayer['lineup_player_type_id'];
            }

            if (isset($lineupPlayer['order'])) {
                $dataLineUp['order'] = $lineupPlayer['order'];
            }

            $this->matchPlayerRepository->create($dataLineUp);
        }
    }

    /**
     * Add rivals match
     */
    private function addPlayersMatch($playersData, $match_id)
    {
        $this->matchPlayerRepository->deleteByCriteria([
            'competition_match_id' => $match_id,
        ]);
        //Store player case swimming
        foreach ($playersData as $player) {
            $this->matchPlayerRepository->create([
                'competition_match_id' => $match_id,
                'player_id' => $player
            ]);
        }
    }

    /**
     * Add rivals match
     */
    private function addRivalsMatch($rivalsData, $match_id)
    {
        $this->matchRivalRepository->deleteByCriteria([
            'competition_match_id' => $match_id,
        ]);

        //Store rival player case swimming
        foreach ($rivalsData as $rival) {
            $this->matchRivalRepository->create([
                'competition_match_id' => $match_id,
                'rival_player' => $rival
            ]);
        }
    }

    /**
     * Retrieve score by match
     */
    private function getScoreByMatch($match)
    {
        $scouting = $match->scouting;

        if (!$scouting) {
            $match->score = null;
        } else {
            $results = $this->scoutingResultRepository->findOneBy([
                'scouting_id' => $scouting->id
            ]);

            $match->score = $results->data->score ?? null;

            $match->makeHidden('scouting');
        }

        return $match;
    }
}
