<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Rucks
{
    const RUCK_WON_SIDE_EFFECT = 'RUCK_WON_SIDE_EFFECT';
    const RUCK_LOST_SIDE_EFFECT = 'RUCK_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_rucks';

    /**
     * Processor used for calculate the total rucks
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_rucks = $stats->activitiesFromSideEffect(self::RUCK_WON_SIDE_EFFECT);
        $lost_rucks = $stats->activitiesFromSideEffect(self::RUCK_LOST_SIDE_EFFECT);
        $total_rucks = count($won_rucks['own']) + count($lost_rucks['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_rucks);

        return $next($stats);
    }
}
