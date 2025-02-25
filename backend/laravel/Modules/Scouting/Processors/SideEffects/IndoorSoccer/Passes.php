<?php

namespace Modules\Scouting\Processors\SideEffects\IndoorSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Passes
{
    const PASS_SUCCESSFUL_SIDE_EFFECT = 'PASS_SUCCESSFUL_SIDE_EFFECT';
    const PASS_MISSED_SIDE_EFFECT = 'PASS_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_passes';

    /**
     * Processor used for calculate the total passses
     * (successful and missed) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $successful_passes = $stats->activitiesFromSideEffect(self::PASS_SUCCESSFUL_SIDE_EFFECT);
        $missed_passes = $stats->activitiesFromSideEffect(self::PASS_MISSED_SIDE_EFFECT);
        $total_passes = count($successful_passes['own']) + count($missed_passes['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_passes);

        return $next($stats);
    }
}
