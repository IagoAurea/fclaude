<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class ExtraPoints
{
    const EXTRA_POINT_SCORED_SIDE_EFFECT = 'EXTRA_POINT_SCORED_SIDE_EFFECT';
    const EXTRA_POINT_MISSED_SIDE_EFFECT = 'EXTRA_POINT_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_extra_points_attempts';

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
        $extra_points_scored = $stats->activitiesFromSideEffect(self::EXTRA_POINT_SCORED_SIDE_EFFECT);
        $extra_points_missed = $stats->activitiesFromSideEffect(self::EXTRA_POINT_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($extra_points_scored['own']));
        $stats->score->addToRival(count($extra_points_scored['rival']));

        $total_extra_points = count($extra_points_scored['own']) + count($extra_points_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_extra_points);

        return $next($stats);
    }
}
