<?php

namespace Modules\Scouting\Processors\SideEffects\Volleyball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Serves
{
    const SERVE_SIDE_EFFECT = 'SERVE_SIDE_EFFECT';

    const SERVER_POINTS = 'serve_points';
    const SERVER_ERRORS = 'serve_errors';

    const STATISTIC_NAME = 'total_serves';

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
        $serves = $stats->activitiesFromSideEffect(self::SERVE_SIDE_EFFECT);

        $stats->setStatistic(self::STATISTIC_NAME, count($serves['own']));

        return $next($stats);
    }
}
