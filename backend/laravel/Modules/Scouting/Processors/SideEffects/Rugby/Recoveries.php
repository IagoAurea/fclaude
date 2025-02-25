<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Recoveries
{
    const SIDE_EFFECT = 'RECOVERY_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_recoveries';

    /**
     * Processor used for calculate the total passes
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $recoveries = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $total_recoveries = count($recoveries['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_recoveries);

        return $next($stats);
    }
}
