<?php

namespace Modules\Scouting\Services;

use Modules\Scouting\Services\ScoutingResultService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Scouting\Processors\Interfaces\ResultsProcessorInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Services\Interfaces\PlayerStatisticServiceInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;

class PlayerStatisticService implements PlayerStatisticServiceInterface
{
    /**
     * Processor
     * @var $resultsProcessor
     */
    protected $resultsProcessor;

    /**
     * Repository
     * @var $competitionMatchPlayerRepository
     */
    protected $competitionMatchPlayerRepository;

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
     * Repository
     * @var $competitionRepository
     */
    protected $competitionRepository;

    /**
     * Repository
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $scoutingResultService
     */
    protected $scoutingResultService;

    public function __construct(
        ResultsProcessorInterface $resultsProcessor,
        CompetitionMatchPlayerRepositoryInterface $competitionMatchPlayerRepository,
        ScoutingRepositoryInterface $scoutingRepository,
        ScoutingResultRepositoryInterface $scoutingResultRepository,
        PlayerRepositoryInterface $playerRepository,
        CompetitionRepositoryInterface $competitionRepository,
        ScoutingResultService $scoutingResultService
    ) {
        $this->resultsProcessor = $resultsProcessor;
        $this->competitionMatchPlayerRepository = $competitionMatchPlayerRepository;
        $this->scoutingResultRepository = $scoutingResultRepository;
        $this->scoutingRepository = $scoutingRepository;
        $this->playerRepository = $playerRepository;
        $this->competitionRepository = $competitionRepository;
        $this->scoutingResultService = $scoutingResultService;
    }

    /**
     * Retrieve statistic competitions matches by player
     */
    public function byPlayer($player)
    {
        $competition_matches = $this->competitionMatchPlayerRepository->playedGamesByPlayer($player->id);

        foreach($competition_matches as $match) {
            $scouting = $this->scoutingRepository->findOneBy([
                'competition_match_id' => $match->competition_match_id
            ]);
            
            if(!$scouting) {
                $match->score = null;

                continue;
            }
            
            $match->score = $scouting->scoutingResults->data->score ?? null;
        }

        $competition_matches_ids = $competition_matches->pluck('competition_match_id')->toArray();

        $scoutings = $this
            ->scoutingRepository
            ->findIn('competition_match_id', $competition_matches_ids);

        $scouting_results = $this
            ->scoutingResultRepository
            ->findIn('scouting_id', $scoutings->pluck('id')->toArray());

        // $player_results = $this->resultsProcessor->playerMatchesResults($competition_matches_ids, $player->id);

        $player_statistics_in_competition = $this->resultsProcessor->sumStats($scouting_results);

        return [
            'competition_matches' => $competition_matches,
            // 'stats_per_game' => $player_results,
            'general_statistics' =>$this->scoutingResultService->convertStatisticsBySport(
                $player_statistics_in_competition, $player->team_id)
        ];

    }


    public function byCompetition($competition_id, $player_id)
    {
        // retrieve the data of the competition,
        $competition = $this
            ->competitionRepository
            ->findOneBy(['id' => $competition_id]);

        if (!$competition) {
            throw new ModelNotFoundException;
        }

        // the results and statistics of the games he played,
        $played_games = $this
            ->competitionMatchPlayerRepository
            ->playedGamesByCompetition($competition_id, $player_id);

        $competition_matches = $played_games->pluck('id')->toArray();

        $scoutings = $this
            ->scoutingRepository
            ->findIn('competition_match_id', $competition_matches);

        $scouting_results = $this
            ->scoutingResultRepository
            ->findIn('scouting_id', $scoutings->pluck('id')->toArray());

        $player_results = $this->resultsProcessor->playerMatchesResults($competition_matches, $player_id);
        $player_statistics_in_competition = $this->resultsProcessor->sumStats($scouting_results);

        // general statistics scoutings associated to that competition
        return [
            'competition' => $competition,
            'matches_played' => $played_games,
            'results' => $scouting_results,
            'stats_per_game' => $player_results,
            'general_statistics' => $player_statistics_in_competition
        ];
    }
}
