<?php

namespace Modules\Scouting\Processors\SideEffects\Football;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Duels
{
    const DUEL_WON_SIDE_EFFECT = 'DUEL_WON_SIDE_EFFECT';
    const DUEL_LOST_SIDE_EFFECT = 'DUEL_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_duels';

    /**
     * Processor used for calculate the total duels
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_duels = $stats->activitiesFromSideEffect(self::DUEL_WON_SIDE_EFFECT);
        $lost_duels = $stats->activitiesFromSideEffect(self::DUEL_LOST_SIDE_EFFECT);
        $total_duels = count($won_duels['own']) + count($lost_duels['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_duels);

        return $next($stats);
    }
}
