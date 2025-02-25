<?php

namespace Modules\Scouting\Processors\SideEffects\IceHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Throws
{
    const THROW_ON_TARGET_SIDE_EFFECT = 'THROW_ON_TARGET_SIDE_EFFECT';
    const THROW_OFF_TARGET_SIDE_EFFECT = 'THROW_OFF_TARGET_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_throws';

    /**
     * Processor used for calculate the total throws
     * (on target + off target) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $throws_on_target = $stats->activitiesFromSideEffect(self::THROW_ON_TARGET_SIDE_EFFECT);
        $throws_off_target = $stats->activitiesFromSideEffect(self::THROW_OFF_TARGET_SIDE_EFFECT);
        $total_throws = count($throws_on_target['own']) + count($throws_off_target['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_throws);

        return $next($stats);
    }
}
