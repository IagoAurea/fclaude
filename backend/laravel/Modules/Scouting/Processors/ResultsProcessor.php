<?php

namespace Modules\Scouting\Processors;

use Exception;
use Modules\Scouting\Repositories\Interfaces\ScoutingActivityRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Processors\Interfaces\ResultsProcessorInterface;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Scouting\Exceptions\SportNotSupportedException;
use Illuminate\Pipeline\Pipeline;

class ResultsProcessor implements ResultsProcessorInterface
{
    /**
     * * Variable
     *
     * @var $sport
     */
    private $sport;

    /**
     * * Repository
     *
     * @var $scoutingRepository
     */
    protected $scoutingRepository;

    /**
     * * Repository
     *
     * @var $scoutingActivityRepository
     */
    protected $scoutingActivityRepository;

    /**
     * * ScoutingController constructor.
     * @param ScoutingRepositoryInterface $scoutingRepository
     */
    public function __construct(
        ScoutingRepositoryInterface $scoutingRepository,
        ScoutingActivityRepositoryInterface $scoutingActivityRepository
    ) {
        $this->scoutingRepository = $scoutingRepository;
        $this->scoutingActivityRepository = $scoutingActivityRepository;
    }

    /**
     * * It process the scouting activities associated
     * * to the given competition match and returns
     * * the results of the scouting as an array
     *
     * @param string $competition_match_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function match($competition_match_id, $all = true)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);

            $this->sport = $this->scoutingRepository->getSport($scouting);
 
            $activities = $this->scoutingActivityRepository->getMatchActivities($scouting->id);
        } catch (CompetitionMatchNotFoundException $exception) {
            throw $exception;
        }

        return $this->process($activities, $scouting, $all);
    }

    /**
     * * It returns the scouting activities associated
     * * to the given competition match and a
     * * specific player
     *
     * @param string $competition_match_id
     * @param string $player_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function playerMatchActions($competition_match_id, $player_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);
        
            $this->sport = $this->scoutingRepository->getSport($scouting);
        
            $activities = $this->scoutingActivityRepository->getPlayerMatchActivities($scouting->id, $player_id);
        } catch (CompetitionMatchNotFoundException $exception) {
            throw $exception;
        }

        return $activities;
    }

    /**
     * * It returns the scouting activities associated
     * * to the given competition match and a
     * * specific player
     *
     * @param string $competition_match_id
     * @param string $player_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function playerMatchResults($competition_match_id, $player_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);
            
            $this->sport = $this->scoutingRepository->getSport($scouting);
            
            $activities = $this->scoutingActivityRepository->getPlayerMatchActivities($scouting->id, $player_id);
        } catch (CompetitionMatchNotFoundException $exception) {
            throw $exception;
        }

        return $this->process($activities, $scouting);
    }

    /**
     * * It returns the scouting activities associated
     * * to the given competition match and a
     * * specific player
     *
     * @param string $competition_match_id
     * @param string $player_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function playerMatchesResults($competition_matches, $player_id)
    {
        $results = [];
        try {
            foreach ($competition_matches as $competition_match_id) {
                $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);

                $this->sport = $this->scoutingRepository->getSport($scouting);

                $activities = $this->scoutingActivityRepository->getPlayerMatchActivities($scouting->id, $player_id);

                $results[] = array_merge(['competition_match_id' => $competition_match_id], $this->process($activities, $scouting));
            }
        } catch (CompetitionMatchNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw $exception;
        }
        return $results;
    }

    /**
     * * It returns the scouting activities associated
     * * to the given competition match and a
     * * specific player
     *
     * @param string $competition_match_id
     * @param string $player_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function sumStats($stats)
    {
        $statistics = [];

        $stats->each(function ($stat) use (&$statistics) {
            $keys = array_keys((array)$stat->data->statistics);
            foreach ($keys as $key) {
                if (!isset($statistics[$key])) {
                    $statistics[$key] = 0;
                }
                $statistics[$key] += (int) $stat->data->statistics->{$key};
            }
        });

        return $statistics;
    }

    /**
     * * Handler for processing a collection of scouting
     * * activities, passing them though a flow of
     * * processors that vary depending on the
     * * sport associated with, returning
     * * the results at the end of it
     *
     * @param Collection $activities
     * @return array
     */
    private function process($activities, $scouting, $all = true)
    {
        $statistic = app(Statistic::class, [
            'activities' => $activities,
            'score' => $this->getScoringSystem([
                'scouting' => $scouting
            ]),
            'sport' => $this->sport
        ]);

        return app(Pipeline::class)
            ->send($statistic)
            ->through($this->getProcessors())
            ->thenReturn()
            ->getResults($all);
    }

    /**
     * * Returns the list of processors associated
     * * to the given sport, using the sport code
     * * as the needle for the search on
     * * the configuration object
     *
     * @throws Modules\Scouting\Exceptions\SportNotSupportedException
     * @return array
     */
    private function getProcessors()
    {
        if (!isset(config('scouting.processors')[$this->sport->code])) {
            throw new SportNotSupportedException($this->sport->code);
        }

        return config('scouting.processors')[$this->sport->code];
    }

    /**
     * * Returns the list of processors associated
     * * to the given sport, using the sport code
     * * as the needle for the search on
     * * the configuration object
     *
     * @throws Modules\Scouting\Exceptions\SportNotSupportedException
     * @return array
     */
    private function getScoringSystem($params)
    {
        if (!isset(config('scouting.scoring_systems')[$this->sport->code])) {
            throw new SportNotSupportedException($this->sport->code);
        }

        return app(config('scouting.scoring_systems')[$this->sport->code], $params);
    }
}
