<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Clearences
{
    const CLEARENCE_WON_SIDE_EFFECT = 'CLEARENCE_WON_SIDE_EFFECT';
    const CLEARENCE_LOST_SIDE_EFFECT = 'CLEARENCE_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_clearences';

    /**
     * Processor used for calculate the total passes
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_clearences = $stats->activitiesFromSideEffect(self::CLEARENCE_WON_SIDE_EFFECT);
        $lost_clearences = $stats->activitiesFromSideEffect(self::CLEARENCE_LOST_SIDE_EFFECT);
        $total_clearences = count($won_clearences['own']) + count($lost_clearences['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_clearences);

        return $next($stats);
    }
}
