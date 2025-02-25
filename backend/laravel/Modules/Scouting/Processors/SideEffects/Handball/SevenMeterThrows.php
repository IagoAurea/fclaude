<?php

namespace Modules\Scouting\Processors\SideEffects\Handball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class SevenMeterThrows
{
    const SEVEN_METER_SCORED_SIDE_EFFECT = 'PENALTY_SCORED_SIDE_EFFECT';
    const SEVEN_METER_MISSED_SIDE_EFFECT = 'PENALTY_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_seven_meter_throws';

    /**
     * Processor used for calculate the total of
     * seven meter throws (missed and scored)
     * and add the goals to the score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $seven_meter_scored = $stats->activitiesFromSideEffect(self::SEVEN_METER_SCORED_SIDE_EFFECT);
        $seven_meter_missed = $stats->activitiesFromSideEffect(self::SEVEN_METER_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($seven_meter_scored['own']));
        $stats->score->addToRival(count($seven_meter_missed['rival']));

        $total_seven_meter_throws = count($seven_meter_scored['own']) + count($seven_meter_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_seven_meter_throws);

        return $next($stats);
    }
}
