<?php

namespace Modules\Scouting\Processors\SideEffects\Football;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Shots
{
    const SHOT_ON_TARGET_SIDE_EFFECT = 'SHOT_ON_TARGET_SIDE_EFFECT';
    const SHOT_OFF_TARGET_SIDE_EFFECT = 'SHOT_OFF_TARGET_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_shots';

    /**
     * Processor used for calculate the total shots
     * (on target + off target) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $shots_on_target = $stats->activitiesFromSideEffect(self::SHOT_ON_TARGET_SIDE_EFFECT);
        $shots_off_target = $stats->activitiesFromSideEffect(self::SHOT_OFF_TARGET_SIDE_EFFECT);
        $total_shots = count($shots_on_target['own']) + count($shots_off_target['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_shots);

        return $next($stats);
    }
}
