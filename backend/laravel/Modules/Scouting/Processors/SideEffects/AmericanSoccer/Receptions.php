<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Receptions
{
    const RECEPTION_WON_SIDE_EFFECT = 'RECEPTION_WON_SIDE_EFFECT';
    const RECEPTION_LOST_SIDE_EFFECT = 'RECEPTION_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_receptions';

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
        $won_receptions = $stats->activitiesFromSideEffect(self::RECEPTION_WON_SIDE_EFFECT);
        $lost_receptions = $stats->activitiesFromSideEffect(self::RECEPTION_LOST_SIDE_EFFECT);
        $total_receptions = count($won_receptions['own']) + count($lost_receptions['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_receptions);

        return $next($stats);
    }
}
