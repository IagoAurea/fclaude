<?php

namespace Modules\Scouting\Processors\SideEffects\Padel;

use Modules\Scouting\Processors\Statistic;
use Closure;

class DoubleFouls
{
    const DOUBLE_FOUL_SIDE_EFFECT = 'DOUBLE_FOUL_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_double_fouls';

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
        $double_fouls = $stats->activitiesFromSideEffect(self::DOUBLE_FOUL_SIDE_EFFECT);
        $stats->setStatistic(self::STATISTIC_NAME, count($double_fouls['own']));
        $stats->score->addToRival(1 * count($double_fouls['own']));
        $stats->score->addToOwn(1 * count($double_fouls['rival']));

        return $next($stats);
    }
}
