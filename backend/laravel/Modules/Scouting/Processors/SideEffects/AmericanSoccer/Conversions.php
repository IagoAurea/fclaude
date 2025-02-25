<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Conversions
{
    const CONVERSION_SCORED_SIDE_EFFECT = 'CONVERSION_SCORED_SIDE_EFFECT';
    const CONVERSION_MISSED_SIDE_EFFECT = 'CONVERSION_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_conversion_attempts';

    /**
     * Processor used for calculate the total conversions
     * (missed and scored) and add the points to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $conversions_scored = $stats->activitiesFromSideEffect(self::CONVERSION_SCORED_SIDE_EFFECT);
        $conversions_missed = $stats->activitiesFromSideEffect(self::CONVERSION_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($conversions_scored['own']), 2);
        $stats->score->addToRival(count($conversions_scored['rival']), 2);

        $total_conversions = count($conversions_scored['own']) + count($conversions_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_conversions);

        return $next($stats);
    }
}
