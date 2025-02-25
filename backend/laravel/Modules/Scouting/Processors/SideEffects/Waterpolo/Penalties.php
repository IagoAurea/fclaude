<?php

namespace Modules\Scouting\Processors\SideEffects\Waterpolo;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Penalties
{
    const PENALTY_SCORED_SIDE_EFFECT = 'PENALTY_SCORED_SIDE_EFFECT';
    const PENALTY_MISSED_SIDE_EFFECT = 'PENALTY_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_penalties';
    const STATISTIC_NAME_RIVAL = 'total_rival_penalties';

    /**
     * Processor used for calculate the total penalties
     * (missed and scored) and add the goals to the
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

        $stats->score->addToOwn(count($penalties_scored['own']));
        $stats->score->addToRival(count($penalties_scored['rival']));

        $total_penalties = count($penalties_scored['own']) + count($penalties_missed['own']);
        $total_rival_penalties = count($penalties_scored['rival']) + count($penalties_missed['rival']);

        $stats->setStatistic(self::STATISTIC_NAME_OWN, $total_penalties);
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, $total_rival_penalties);

        return $next($stats);
    }
}
