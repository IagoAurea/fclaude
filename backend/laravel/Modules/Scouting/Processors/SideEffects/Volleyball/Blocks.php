<?php

namespace Modules\Scouting\Processors\SideEffects\Volleyball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Blocks
{
    const BLOCK_SIDE_EFFECT = 'BLOCK_SIDE_EFFECT';

    const BLOCK_POINTS = 'block_point';
    const BLOCK_ERRORS = 'block_errors';

    const STATISTIC_NAME = 'total_blocks';

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
        $serves = $stats->activitiesFromSideEffect(self::BLOCK_SIDE_EFFECT);

        $stats->setStatistic(self::STATISTIC_NAME, count($serves['own']));

        return $next($stats);
    }
}
