<?php

namespace Modules\Scouting\Processors\SideEffects\Badminton;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Shots
{
    const SHOT_SIDE_EFFECT = 'SHOT_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_shots';

    /**
     * Processor used for calculate the total shots
     * of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $shots = $stats->activitiesFromSideEffect(self::SHOT_SIDE_EFFECT);
        $stats->setStatistic(self::STATISTIC_NAME, count($shots['own']));

        return $next($stats);
    }
}
