<?php

namespace Modules\Scouting\Services;

use Carbon\Carbon;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Scouting\Exceptions\ScoutingAlreadyFinishedException;
use Modules\Scouting\Exceptions\ScoutingAlreadyPausedException;
use Modules\Scouting\Exceptions\ScoutingAlreadyStartedException;
use Modules\Scouting\Exceptions\ScoutingFinishedException;
use Modules\Scouting\Exceptions\ScoutingHasNotStartedException;
use Modules\Scouting\Exceptions\ScoutingNotFoundException;
use Modules\Scouting\Exceptions\ScoutingPausedException;
use Modules\Scouting\Processors\Interfaces\ResultsProcessorInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Scouting\Services\Interfaces\ScoutingStatusServiceInterface;

class ScoutingStatusService implements ScoutingStatusServiceInterface
{
    /**
     * Repository
     * @var $competitionMatchRepository
     */
    protected $competitionMatchRepository;

    /**
     * Repository
     * @var $scoutingResultsRepository
     */
    protected $scoutingResultsRepository;
    
    /**
     * @var $resultsProcessor
     */
    protected $resultsProcessor;

    /**
     * Repository
     * @var $scoutingRepository
     */
    protected $scoutingRepository;

    public function __construct(
        CompetitionMatchRepositoryInterface $competitionMatchRepository,
        ScoutingRepositoryInterface $scoutingRepository,
        ResultsProcessorInterface $resultsProcessor,
        ScoutingResultRepositoryInterface $scoutingResultsRepository
    ) {
        $this->competitionMatchRepository = $competitionMatchRepository;
        $this->scoutingRepository = $scoutingRepository;
        $this->resultsProcessor = $resultsProcessor;
        $this->scoutingResultsRepository = $scoutingResultsRepository;
    }

    /**
     * Start a scouting for a given competition match
     * 
     * @param int $competition_match_id
     * @return Scouting;
     */
    public function start($competition_match_id)
    {
        $competitionMatch = $this->competitionMatchRepository->find($competition_match_id);
        if (!$competitionMatch) {
            throw new CompetitionMatchNotFoundException;
        }

        $scout = $this->scoutingRepository->findOrCreateScout($competitionMatch->id);
        if ($scout->status == Scouting::STATUS_STARTED) {
            throw new ScoutingAlreadyStartedException;
        }

        if ($scout->status == Scouting::STATUS_NOT_STARTED) {
            $response = $this->scoutingRepository->changeStatus($scout, Scouting::STATUS_STARTED);
        }

        if ($scout->status == Scouting::STATUS_PAUSED) {
            $response = $this->scoutingRepository->changeStatus($scout, Scouting::STATUS_STARTED);
        }

        if ($scout->status == Scouting::STATUS_FINISHED) {
            throw new ScoutingFinishedException;
        }

        return $response;
    }

    /**
     * Pause a scouting for a given competition match
     *
     * @param int $competition_match_id
     * @return Scouting;
     */
    public function pause($competition_match_id, $request)
    {
        $competitionMatch = $this->competitionMatchRepository->find($competition_match_id);
        if (!$competitionMatch) {
            throw new CompetitionMatchNotFoundException;
        }

        $scout = $this->scoutingRepository->findOneBy(['competition_match_id' => $competitionMatch->id]);
        if (!$scout) {
            throw new ScoutingNotFoundException;
        }

        if ($scout->status == Scouting::STATUS_NOT_STARTED) {
            throw new ScoutingHasNotStartedException;
        }

        if ($scout->status == Scouting::STATUS_PAUSED) {
            throw new ScoutingAlreadyPausedException;
        }

        if ($scout->status == Scouting::STATUS_FINISHED) {
            throw new ScoutingFinishedException;
        }

        return $this->scoutingRepository->changeStatus($scout, Scouting::STATUS_PAUSED, $request);
    }

    /**
     * Finish a scouting for a given competition match
     * 
     * @param int $competition_match_id
     * @return Scouting;
     */
    public function finish($competition_match_id, $request)
    {
        $competitionMatch = $this->competitionMatchRepository->find($competition_match_id);
        if (!$competitionMatch) {
            throw new CompetitionMatchNotFoundException;
        }

        $scout = $this->scoutingRepository->findOneBy(['competition_match_id' => $competitionMatch->id]);
        if (!$scout) {
            throw new ScoutingNotFoundException;
        }

        if ($scout->status == Scouting::STATUS_NOT_STARTED) {
            throw new ScoutingHasNotStartedException;
        }

        if ($scout->status == Scouting::STATUS_PAUSED) {
            throw new ScoutingPausedException;
        }

        if ($scout->status == Scouting::STATUS_FINISHED) {
            throw new ScoutingAlreadyFinishedException;
        }

        $response = $this->scoutingRepository->changeStatus($scout, Scouting::STATUS_FINISHED, $request);
        
        $results = $this->resultsProcessor->match($competition_match_id);

        $this
            ->scoutingResultsRepository
            ->create([
                'scouting_id' => $scout->id,
                'in_game_time' => $request['in_game_time'],
                'data' => json_encode($results),
                'use_tool' => true
            ]);

        return $response;
    }
}
