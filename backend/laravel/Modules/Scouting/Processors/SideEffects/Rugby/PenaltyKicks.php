<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class PenaltyKicks
{
    const PENALTY_SCORED_SIDE_EFFECT = 'PENALTY_SCORED_SIDE_EFFECT';
    const PENALTY_MISSED_SIDE_EFFECT = 'PENALTY_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_penalty_kicks';

    /**
     * Processor used for calculate the total penalties
     * (missed and scored) and add the points to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $penalties_scored = $stats->activitiesFromSideEffect(self::PENALTY_SCORED_SIDE_EFFECT);
        $penalties_missed = $stats->activitiesFromSideEffect(self::PENALTY_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($penalties_scored['own']), 3);
        $stats->score->addToRival(count($penalties_scored['rival']), 3);

        $total_penalties = count($penalties_scored['own']) + count($penalties_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_penalties);

        return $next($stats);
    }
}
