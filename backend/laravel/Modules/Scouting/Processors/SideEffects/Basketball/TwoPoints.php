<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class TwoPoints
{
    const TWO_POINTS_SCORED_SIDE_EFFECT = 'TWO_POINTS_SCORED_SIDE_EFFECT';
    const TWO_POINTS_MISSED_SIDE_EFFECT = 'TWO_POINTS_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_two_points';

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
        $two_points_scored = $stats->activitiesFromSideEffect(self::TWO_POINTS_SCORED_SIDE_EFFECT);
        $two_points_missed = $stats->activitiesFromSideEffect(self::TWO_POINTS_MISSED_SIDE_EFFECT);

        $total_two_points = count($two_points_scored['own']) + count($two_points_missed['own']);
        
        $stats->score->addToOwn(count($two_points_scored['own']), 2);
        $stats->score->addToRival(count($two_points_scored['rival']), 2);

        $stats->setStatistic(self::STATISTIC_NAME, $total_two_points);

        return $next($stats);
    }
}
