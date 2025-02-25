<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Tackles
{
    const TACKLE_WON_SIDE_EFFECT = 'TACKLE_WON_SIDE_EFFECT';
    const TACKLE_LOST_SIDE_EFFECT = 'TACKLE_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_tackles';

    /**
     * Processor used for calculate the total tackles
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_tackles = $stats->activitiesFromSideEffect(self::TACKLE_WON_SIDE_EFFECT);
        $lost_tackles = $stats->activitiesFromSideEffect(self::TACKLE_LOST_SIDE_EFFECT);
        $total_tackles = count($won_tackles['own']) + count($lost_tackles['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_tackles);

        return $next($stats);
    }
}
