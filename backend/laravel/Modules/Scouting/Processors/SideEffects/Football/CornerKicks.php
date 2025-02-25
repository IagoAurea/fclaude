<?php

namespace Modules\Scouting\Processors\SideEffects\Football;

use Modules\Scouting\Processors\Statistic;
use Closure;

class CornerKicks
{
    const CORNER_KICK_WON_SIDE_EFFECT = 'CORNER_KICK_WON_SIDE_EFFECT';
    const CORNER_KICK_LOST_SIDE_EFFECT = 'CORNER_KICK_LOST_SIDE_EFFECT';
    // const STATISTIC_NAME = 'total_corner_kicks';

    /**
     * Processor used for calculate the total shots
     * (on target + off target) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $corner_kick_won = $stats->activitiesFromSideEffect(self::CORNER_KICK_WON_SIDE_EFFECT);
        $corner_kick_lost = $stats->activitiesFromSideEffect(self::CORNER_KICK_LOST_SIDE_EFFECT);
        // $total_corners = count($corner_kick_won['own']) + count($corner_kick_lost['own']);

        // $stats->setStatistic(self::STATISTIC_NAME, $total_corners);

        return $next($stats);
    }
}
