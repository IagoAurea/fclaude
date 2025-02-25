<?php

namespace Modules\Scouting\Processors\SideEffects\Volleyball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class FootKicks
{
    const FOOT_KICK_SIDE_EFFECT = 'FOOT_KICK_SIDE_EFFECT';

    const FOOT_KICK = 'foot_kick';
    const FOOT_KICK_ERROR = 'foot_kick_error';

    const STATISTIC_NAME = 'total_foot_kicks';

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
        $serves = $stats->activitiesFromSideEffect(self::FOOT_KICK_SIDE_EFFECT);

        $stats->setStatistic(self::STATISTIC_NAME, count($serves['own']));

        return $next($stats);
    }
}
