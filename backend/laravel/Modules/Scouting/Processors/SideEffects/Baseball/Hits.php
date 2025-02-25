<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Hits
{
    const SIDE_EFFECT = 'HITS_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_own_hits';
    const STATISTIC_NAME_RIVAL = 'total_rival_hits';

    /**
     * * Processor used for handle the strike actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        if (!$activity->action->rival_team_action) {
            $stats->increaseStatistic(self::STATISTIC_NAME_OWN);
        } else {
            $stats->increaseStatistic(self::STATISTIC_NAME_RIVAL);
        }
        return $stats;
    }
}
