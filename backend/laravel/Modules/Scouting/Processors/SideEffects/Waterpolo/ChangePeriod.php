<?php

namespace Modules\Scouting\Processors\SideEffects\Waterpolo;

use Modules\Scouting\Processors\Statistic;
use Closure;

class ChangePeriod
{
    const PERIOD = [
        0 => 'period_1',
        1 => 'period_2',
        2 => 'period_3',
        3 => 'period_4',
        4 => 'time_extra_1',
        5 => 'time_extra_2',
        6 => 'penalties',
    ];

    const SIDE_EFFECT = 'CHANGE_PERIOD_SIDE_EFFECT';
    const STATISTIC_NAME = 'actual_period';

    /**
     * Processor used for calculate the total penalties
     * (missed and scored) and add the goals to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $change_period_activities = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $total_periods = count($change_period_activities['own']);

        $statistic = isset(self::PERIOD[$total_periods]) ? self::PERIOD[$total_periods] : self::PERIOD[6];
        $stats->setStatistic(self::STATISTIC_NAME, $statistic);

        return $next($stats);
    }
}
