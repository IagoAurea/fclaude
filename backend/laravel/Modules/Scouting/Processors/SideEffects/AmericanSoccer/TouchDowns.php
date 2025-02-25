<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class TouchDowns
{
    const SIDE_EFFECT = 'TOUCHDOWN_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_touchdowns';

    /**
     * Processor used for calculate the score
     * for own and rival team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $touchdowns = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);

        $stats->score->addToOwn(count($touchdowns['own']), 6);
        $stats->score->addToRival(count($touchdowns['rival']), 6);

        $total_touchdowns = count($touchdowns['own']);
        $stats->setStatistic(self::STATISTIC_NAME, $total_touchdowns);

        return $next($stats);
    }
}
