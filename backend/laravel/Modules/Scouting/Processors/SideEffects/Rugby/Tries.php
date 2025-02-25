<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Tries
{
    const SIDE_EFFECT = 'TRY_SIDE_EFFECT';

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
        $tries = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);

        $stats->score->addToOwn(count($tries['own']), 5);
        $stats->score->addToRival(count($tries['rival']), 5);

        return $next($stats);
    }
}
