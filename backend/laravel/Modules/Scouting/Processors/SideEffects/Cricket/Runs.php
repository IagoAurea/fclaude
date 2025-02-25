<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Runs
{
    const SIDE_EFFECT = 'RUNS_SIDE_EFFECT';

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
            $stats->score->addToRival(1);
        } else {
            $stats->score->addToOwn(1);
        }

        return $stats;
    }
}
