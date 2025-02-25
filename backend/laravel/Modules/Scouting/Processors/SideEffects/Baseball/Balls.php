<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Balls
{
    const SIDE_EFFECT = 'BALL_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_own_balls';

    /**
     * * Processor used for handle the strike actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $walk = $stats->score->ball();
        $stats->increaseStatistic(self::STATISTIC_NAME);
        if ($walk) {
            $stats->increaseStatistic(Walks::STATISTIC_NAME);
        }

        return $stats;
    }
}
