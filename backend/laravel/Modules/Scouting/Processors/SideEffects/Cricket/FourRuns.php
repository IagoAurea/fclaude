<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\Statistic;
use Closure;

class FourRuns
{
    const SIDE_EFFECT = 'FOUR_RUNS_SIDE_EFFECT';

    /**
     * * Processor used for calculate the score
     * * for own and rival team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, $activity)
    {
        if ($activity->action->rival_team_action) {
            $stats->score->addToRival(4);
        } else {
            $stats->score->addToOwn(4);
        }

        return $stats;
    }
}
