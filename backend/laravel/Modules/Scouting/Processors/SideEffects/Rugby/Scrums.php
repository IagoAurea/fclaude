<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Scrums
{
    const SCRUM_WON_SIDE_EFFECT = 'SCRUM_WON_SIDE_EFFECT';
    const SCRUM_LOST_SIDE_EFFECT = 'SCRUM_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_scrums';

    /**
     * Processor used for calculate the total scrums
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_scrums = $stats->activitiesFromSideEffect(self::SCRUM_WON_SIDE_EFFECT);
        $lost_scrums = $stats->activitiesFromSideEffect(self::SCRUM_LOST_SIDE_EFFECT);
        $total_scrums = count($won_scrums['own']) + count($lost_scrums['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_scrums);

        return $next($stats);
    }
}
