<?php

namespace Modules\Scouting\Processors\SideEffects\Swimming;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Turns
{
    const TURNS_GOOD_SIDE_EFFECT = 'TURNS_GOOD_SIDE_EFFECT';
    const TURNS_BAD_SIDE_EFFECT = 'TURNS_BAD_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_turns';

    /**
     * Processor used for calculate the total line outs
     * (good and bad) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $good_turns = $stats->activitiesFromSideEffect(self::TURNS_GOOD_SIDE_EFFECT);
        $bad_turns = $stats->activitiesFromSideEffect(self::TURNS_BAD_SIDE_EFFECT);
        $total_turns = count($good_turns['own']) + count($bad_turns['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_turns);

        return $next($stats);
    }
}
