<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Mauls
{
    const MAUL_WON_SIDE_EFFECT = 'MAUL_WON_SIDE_EFFECT';
    const MAUL_LOST_SIDE_EFFECT = 'MAUL_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_mauls';

    /**
     * Processor used for calculate the total mauls
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_mauls = $stats->activitiesFromSideEffect(self::MAUL_WON_SIDE_EFFECT);
        $lost_mauls = $stats->activitiesFromSideEffect(self::MAUL_LOST_SIDE_EFFECT);
        $total_mauls = count($won_mauls['own']) + count($lost_mauls['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_mauls);

        return $next($stats);
    }
}
