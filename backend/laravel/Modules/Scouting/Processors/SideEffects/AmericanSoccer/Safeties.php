<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Safeties
{
    const SIDE_EFFECT = 'SAFETY_SIDE_EFFECT';

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
        $touchdowns = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);

        $stats->score->addToOwn(count($touchdowns['own']), 2);
        $stats->score->addToRival(count($touchdowns['rival']), 2);

        return $next($stats);
    }
}
