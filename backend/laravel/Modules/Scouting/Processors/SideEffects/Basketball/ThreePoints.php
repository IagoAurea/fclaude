<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class ThreePoints
{
    const THREE_POINTS_SCORED_SIDE_EFFECT = 'THREE_POINTS_SCORED_SIDE_EFFECT';
    const THREE_POINTS_MISSED_SIDE_EFFECT = 'THREE_POINTS_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_three_points';

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
        $three_points_scored = $stats->activitiesFromSideEffect(self::THREE_POINTS_SCORED_SIDE_EFFECT);
        $three_points_missed = $stats->activitiesFromSideEffect(self::THREE_POINTS_MISSED_SIDE_EFFECT);

        $total_three_points = count($three_points_scored['own']) + count($three_points_missed['own']);
        
        $stats->score->addToOwn(count($three_points_scored['own']), 3);
        $stats->score->addToRival(count($three_points_scored['rival']), 3);

        $stats->setStatistic(self::STATISTIC_NAME, $total_three_points);

        return $next($stats);
    }
}
