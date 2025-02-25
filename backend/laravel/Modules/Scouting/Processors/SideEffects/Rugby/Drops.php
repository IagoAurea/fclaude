<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Drops
{
    const DROP_SCORED_SIDE_EFFECT = 'DROP_SCORED_SIDE_EFFECT';
    const DROP_MISSED_SIDE_EFFECT = 'DROP_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_drops';

    /**
     * Processor used for calculate the total conversions
     * (missed and scored) and add the points to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $drops_scored = $stats->activitiesFromSideEffect(self::DROP_SCORED_SIDE_EFFECT);
        $drops_missed = $stats->activitiesFromSideEffect(self::DROP_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($drops_scored['own']), 3);
        $stats->score->addToRival(count($drops_missed['rival']), 3);

        $total_drops = count($drops_scored['own']) + count($drops_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_drops);

        return $next($stats);
    }
}
