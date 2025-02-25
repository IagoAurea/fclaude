<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\Statistic;

class Batter
{
    const SIDE_EFFECT = 'BATTER_SIDE_EFFECT';

    /**
     * * Processor used for handle the strike actions
     *
     * @param Statistic $stats
     * @return $stats
     */
    public function handle(Statistic $stats, $activity)
    {
        $stats->score->walk();

        return $stats;
    }
}