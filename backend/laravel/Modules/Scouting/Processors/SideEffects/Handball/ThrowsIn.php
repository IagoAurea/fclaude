<?php

namespace Modules\Scouting\Processors\SideEffects\Handball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class ThrowsIn
{
    const THROW_IN_WON_SIDE_EFFECT = 'THROW_IN_WON_SIDE_EFFECT';
    const THROW_IN_LOST_SIDE_EFFECT = 'THROW_IN_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_throws_in';

    /**
     * Processor used for calculate the total throws in
     * (won and lost) by the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $throws_in_won = $stats->activitiesFromSideEffect(self::THROW_IN_WON_SIDE_EFFECT);
        $throws_in_lost = $stats->activitiesFromSideEffect(self::THROW_IN_LOST_SIDE_EFFECT);
        $total_throws = count($throws_in_won['own']) + count($throws_in_lost['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_throws);

        return $next($stats);
    }
}
