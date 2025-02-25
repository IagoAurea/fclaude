<?php

namespace Modules\Scouting\Processors\SideEffects\Waterpolo;

use Modules\Scouting\Processors\Statistic;
use Closure;

class NeutralBlocks
{
    const NEUTRAL_BLOCK_WON_SIDE_EFFECT = 'NEUTRAL_BLOCK_WON_SIDE_EFFECT';
    const NEUTRAL_BLOCK_LOST_SIDE_EFFECT = 'NEUTRAL_BLOCK_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_neutral_blocks';

    /**
     * Processor used for calculate the total neutral blocks
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_neutral_blocks = $stats->activitiesFromSideEffect(self::NEUTRAL_BLOCK_WON_SIDE_EFFECT);
        $lost_neutral_blocks = $stats->activitiesFromSideEffect(self::NEUTRAL_BLOCK_LOST_SIDE_EFFECT);
        $total_neutral_blocks = count($won_neutral_blocks['own']) + count($lost_neutral_blocks['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_neutral_blocks);

        return $next($stats);
    }
}
