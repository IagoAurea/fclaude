<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Tactics
{
    const TACTIC_WON_SIDE_EFFECT = 'TACTIC_WON_SIDE_EFFECT';
    const TACTIC_LOST_SIDE_EFFECT = 'TACTIC_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_tactics';

    /**
     * Processor used for calculate the total tactics
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_tactics = $stats->activitiesFromSideEffect(self::TACTIC_WON_SIDE_EFFECT);
        $lost_tactics = $stats->activitiesFromSideEffect(self::TACTIC_LOST_SIDE_EFFECT);
        $total_tactics = count($won_tactics['own']) + count($lost_tactics['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_tactics);

        return $next($stats);
    }
}
