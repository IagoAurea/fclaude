<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Runs
{
    const RUN_WON_SIDE_EFFECT = 'RUN_WON_SIDE_EFFECT';
    const RUN_LOST_SIDE_EFFECT = 'RUN_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_runs';

    /**
     * Processor used for calculate the total runs
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_runs = $stats->activitiesFromSideEffect(self::RUN_WON_SIDE_EFFECT);
        $lost_runs = $stats->activitiesFromSideEffect(self::RUN_LOST_SIDE_EFFECT);
        $total_runs = count($won_runs['own']) + count($lost_runs['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_runs);

        return $next($stats);
    }
}
