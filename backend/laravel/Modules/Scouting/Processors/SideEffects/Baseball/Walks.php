<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Walks
{
    const SIDE_EFFECT = 'WALK_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_own_walks';

    /**
     * * Processor used for handle the strike actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $stats->score->walk();
        $stats->increaseStatistic(self::STATISTIC_NAME);

        return $stats;
    }
}
