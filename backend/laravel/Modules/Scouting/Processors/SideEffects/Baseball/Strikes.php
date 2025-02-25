<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Strikes
{
    const SIDE_EFFECT = 'STRIKES_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_own_strikes';

    /**
     * * Processor used for handle the strike actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $stats->score->strike();
        $stats->increaseStatistic(self::STATISTIC_NAME);

        return $stats;
    }
}
