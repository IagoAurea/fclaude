<?php

namespace Modules\Scouting\Services;

use Modules\Scouting\Services\Interfaces\ScoutingResultServiceInterface;
use Modules\Competition\Cache\CompetitionMatchCache;
use Modules\Scouting\Cache\ActionCache;

class ScoutingResultService implements ScoutingResultServiceInterface
{
    /**
     * Cache
     * @var $actionCache
     */
    protected $actionCache;

    /**
     * Repository
     * @var $competitionMatchCache
     */
    protected $competitionMatchCache;

    /**
     * @var array $actionsTotals
     */
    private $actionsTotals;

    /**
     * ScoutingResultService constructor.
     * @param ActionCache $actionCache
     * @param CompetitionMatchCache $competitionMatchCache
     */
    public function __construct(
        ActionCache $actionCache,
        CompetitionMatchCache $competitionMatchCache
    ) {
        $this->actionCache = $actionCache;
        $this->competitionMatchCache = $competitionMatchCache;
        $this->actionsTotals = [];
    }

    public function convertStatisticsBySport($statistics, $sport)
    {
        $this->actionsTotals = $this->actionCache->findAllActionsAndTotalsBySport($sport);

        return $this->obtainStatistic($statistics, true);
    }


    public function convertStatistics($statistics, $competition_match_id, $allStatistics = false, $onlyOwn = false)
    {
        $sport = $this->competitionMatchCache->sportIdByCompetitionMatch($competition_match_id);

        $this->actionsTotals = $this->actionCache->findAllActionsAndTotalsBySport($sport);

        if ($onlyOwn) {
            $statistics = $this->filterStatisticsOwn($statistics);
        }

        return $this->obtainStatistic($statistics, $allStatistics);
    }

    /**
     * Filter statistics own exclude rivals
     * 
     * @param $statistics
     */
    private function filterStatisticsOwn($statistics)
    {
        $actions = array_filter($this->actionsTotals, function($value) {
            return !$value['rival_team_action'] && $value['show_player'];
        });

        $actionsCodes = array_column($actions, 'code');

        foreach($statistics as $key => $statistic) {
            if(!in_array($key, $actionsCodes)) {
                unset($statistics[$key]);
            }
        }

        return $statistics;
    }

    private function obtainStatistic($statistics, $allStatistics)
    {
        $statisticsModified = new \stdClass;

        foreach ($statistics as $statistic => $value) {
            if ($allStatistics) {
                $statisticsModified->$statistic = $this->getDataStatistic($statistic, $value);
            } else {
                if ($this->validateStatisticsSport($statistic)) {
                    $statisticsModified->$statistic = $this->getDataStatistic($statistic, $value, false);
                }
            }
        }

        return $statisticsModified;
    }

    /**
     * Return array data stastistic
     * @param $statistic string
     */
    private function getDataStatistic($statistic, $value, $order = true)
    {
        $rowActionTotal = array_search($statistic, array_column($this->actionsTotals, 'code'));

        $valueStatistic = [
            'value' => $value,
            'name' => (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['name'] : null,
            'plural' => (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['plural'] : null,
            'image' => (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['image'] : null,
            'show' => (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['show'] : false,
            'show_player' => (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['show_player'] : false,
            'custom_params' => (gettype($rowActionTotal) == 'integer') ?
            json_decode($this->actionsTotals[$rowActionTotal]['custom_params'], true) : null,
        ];

        if($order) {
            $valueStatistic = $this->orderStatistic($valueStatistic, $rowActionTotal);
        }
        
        return $valueStatistic;
    }

    /**
     * Order statistic
     */
    private function orderStatistic($statistics, $rowActionTotal)
    {
        $statistics['order'] = (gettype($rowActionTotal) == 'integer') ?
                $this->actionsTotals[$rowActionTotal]['order'] : null;
        $statistics['calculate_total'] = (gettype($rowActionTotal) == 'integer') ?
                json_decode($this->actionsTotals[$rowActionTotal]['calculate_total']) : null;

        return $statistics;
    }

    /**
     * Validate statistics
     */
    private function validateStatisticsSport($statistic)
    {
        $statistics = [
            "actual_period", "fouls", "rival_fouls", "outs", "own_balls", "own_strikes",
            "hit_wicket", "number_of_substitutions", "own_wicket", "rival_outs", "fouls_committed",
            "fouls_received", "total_yards_lost", "total_yards_won", "own_wickets"
        ];

        return in_array($statistic, $statistics);
    }
}
