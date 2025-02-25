<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Errors
{
    const SIDE_EFFECT = 'ERRORS_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_own_errors';
    const STATISTIC_NAME_RIVAL = 'total_rival_errors';

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
            $stats->score->own_error();
        } else {
            $stats->increaseStatistic(self::STATISTIC_NAME_RIVAL);
            $stats->score->rival_error();
        }
        return $stats;
    }
}
