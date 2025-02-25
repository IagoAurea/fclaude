<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\Statistic;

class Overs
{
    const SIDE_EFFECT = 'OVER_SIDE_EFFECT';

    /**
     * * Processor used for handle the over actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $stats->score->changeTurn();

        return $stats;
    }
}
