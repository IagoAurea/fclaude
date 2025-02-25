<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Passes
{
    const PASS_WON_SIDE_EFFECT = 'PASS_WON_SIDE_EFFECT';
    const PASS_LOST_SIDE_EFFECT = 'PASS_LOST_SIDE_EFFECT';
    const PASS_INTERCEPT_SIDE_EFFECT = 'PASS_INTERCEPT_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_passes';

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
        $won_pass = $stats->activitiesFromSideEffect(self::PASS_WON_SIDE_EFFECT);
        $lost_pass = $stats->activitiesFromSideEffect(self::PASS_LOST_SIDE_EFFECT);
        $intercept_pass = $stats->activitiesFromSideEffect(self::PASS_INTERCEPT_SIDE_EFFECT);
        
        $total_passes = count($won_pass['own']) + count($lost_pass['own']) + count($intercept_pass['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_passes);

        return $next($stats);
    }
}
