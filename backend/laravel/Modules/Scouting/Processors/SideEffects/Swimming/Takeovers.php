<?php

namespace Modules\Scouting\Processors\SideEffects\Swimming;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Takeovers
{
    const TAKEOVERS_GOOD_SIDE_EFFECT = 'TAKEOVERS_GOOD_SIDE_EFFECT';
    const TAKEOVERS_BAD_SIDE_EFFECT = 'TAKEOVERS_BAD_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_takeovers';

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
        $good_takeovers = $stats->activitiesFromSideEffect(self::TAKEOVERS_GOOD_SIDE_EFFECT);
        $bad_takeovers = $stats->activitiesFromSideEffect(self::TAKEOVERS_BAD_SIDE_EFFECT);
        $total_takeovers = count($good_takeovers['own']) + count($bad_takeovers['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_takeovers);

        return $next($stats);
    }
}
