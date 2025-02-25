<?php

namespace Modules\Team\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Team\Entities\Team;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class TeamMatchService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * @var object $matchRepository
     */
    protected $matchRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        CompetitionMatchRepositoryInterface $matchRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->matchRepository = $matchRepository;
    }

    /**
     * Retrieves all information about a team's matches regardless of competition
     * @return StaffUser
     *
     * @OA\Schema(
     *  schema="TeamMatchListResponse",
     *  type="object",
     *  description="List all team's matches",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Team match list"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="recent",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="competition_id", type="int64", example="1"),
     *              @OA\Property(property="competition_rival_team_id", type="int64", example="1"),
     *              @OA\Property(property="referee_id", type="int64", example="1"),
     *              @OA\Property(property="weather_id", type="int64", example="1"),
     *              @OA\Property(property="location", type="string", example="string"),
     *              @OA\Property(property="competition_name", type="string", example="string"),
     *              @OA\Property(property="competition_url_image", type="string", example="string"),
     *              @OA\Property(property="match_situation", type="string", example="string"),
     *              @OA\Property(property="start_at", type="string", format="date-time", example="2022-01-01 00:00:00"),
     *              @OA\Property(
     *                  property="weather",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="string"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *              ),
     *              @OA\Property(
     *                  property="competition_rival_team",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="rival_team", type="string", example="string"),
     *                  @OA\Property(property="image_id", type="int64", example="1"),
     *                  @OA\Property(property="url_image", type="string", example="string"),
     *              ),
     *              @OA\Property(
     *                  property="referee",
     *                  type="object",
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="name", type="string", example="string"),
     *                  @OA\Property(property="country_id", type="int64", example="1"),
     *                  @OA\Property(property="province_id", type="int64", example="1"),
     *                  @OA\Property(property="sport_id", type="int64", example="1"),
     *              ),
     *          ),
     *      ),
     *      @OA\Property(
     *          property="next",
     *          type="string",
     *          example="Same array structure as 'recent' property",
     *      ),
     *  ),
     * )
     */
    public function listAllMatches(Team $team)
    {
        try {
            $recentMatches = $this->matchRepository->findAllCompetitionMatches($team, 'recent');

            $nextMatches = $this->matchRepository->findAllCompetitionMatches($team, 'next');

            return [
                'recent' => $recentMatches,
                'next' => $nextMatches
            ];
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
