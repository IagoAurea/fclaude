<?php

namespace Modules\Scouting\Processors\SideEffects\RollerHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Fouls
{
    const SIDE_EFFECT = 'FOUL_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_fouls';
    const STATISTIC_NAME_RIVAL = 'total_rival_fouls';

    /**
     * Processor used for calculate the total fouls
     * of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $fouls = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $stats->setStatistic(self::STATISTIC_NAME_OWN, count($fouls['own']));
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, count($fouls['rival']));

        return $next($stats);
    }
}
