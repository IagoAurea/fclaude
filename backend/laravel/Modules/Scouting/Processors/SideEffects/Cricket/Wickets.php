<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\Statistic;

class Wickets
{
    const SIDE_EFFECT = 'WICKET_SIDE_EFFECT';

    /**
     * * Processor used for handle the wicket actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $stats->score->out();

        return $stats;
    }
}
