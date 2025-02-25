<?php

namespace Modules\Scouting\Processors\SideEffects\Volleyball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Spikes
{
    const SPIKE_SIDE_EFFECT = 'SPIKE_SIDE_EFFECT';
    
    const SPIKE_POINT = 'spike_point';
    const SPIKE_ERROR = 'spike_error';

    const STATISTIC_NAME = 'total_spikes';

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
        $serves = $stats->activitiesFromSideEffect(self::SPIKE_SIDE_EFFECT);

        $stats->setStatistic(self::STATISTIC_NAME, count($serves['own']));

        return $next($stats);
    }
}
