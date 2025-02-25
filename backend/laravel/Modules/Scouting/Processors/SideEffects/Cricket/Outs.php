<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\Statistic;

class Outs
{
    const SIDE_EFFECT = 'OUT_SIDE_EFFECT';

    /**
     * * Processor used for handle the out actions
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
