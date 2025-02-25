<?php

namespace Modules\Scouting\Processors\SideEffects\IndoorSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class DoublePenalties
{
    const DOUBLE_PENALTY_SCORED_SIDE_EFFECT = 'DOUBLE_PENALTY_SCORED_SIDE_EFFECT';
    const DOUBLE_PENALTY_MISSED_SIDE_EFFECT = 'DOUBLE_PENALTY_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_double_penalties';

    /**
     * Processor used for calculate the total double penalties
     * (missed and scored) and add the goals to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $double_penalties_scored = $stats->activitiesFromSideEffect(self::DOUBLE_PENALTY_SCORED_SIDE_EFFECT);
        $double_penalties_missed = $stats->activitiesFromSideEffect(self::DOUBLE_PENALTY_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($double_penalties_scored['own']));
        $stats->score->addToRival(count($double_penalties_scored['rival']));

        $total_penalties = count($double_penalties_scored['own']) + count($double_penalties_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_penalties);

        return $next($stats);
    }
}
