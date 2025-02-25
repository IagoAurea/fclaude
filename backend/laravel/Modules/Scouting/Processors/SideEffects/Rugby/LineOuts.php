<?php

namespace Modules\Scouting\Processors\SideEffects\Rugby;

use Modules\Scouting\Processors\Statistic;
use Closure;

class LineOuts
{
    const LINE_OUT_WON_SIDE_EFFECT = 'LINE_OUT_WON_SIDE_EFFECT';
    const LINE_OUT_LOST_SIDE_EFFECT = 'LINE_OUT_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_line_outs';

    /**
     * Processor used for calculate the total line outs
     * (won and lost) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $won_line_outs = $stats->activitiesFromSideEffect(self::LINE_OUT_WON_SIDE_EFFECT);
        $lost_line_outs = $stats->activitiesFromSideEffect(self::LINE_OUT_LOST_SIDE_EFFECT);
        $total_line_outs = count($won_line_outs['own']) + count($lost_line_outs['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_line_outs);

        return $next($stats);
    }
}
