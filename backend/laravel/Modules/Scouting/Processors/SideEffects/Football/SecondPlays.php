<?php

namespace Modules\Scouting\Processors\SideEffects\Football;

use Modules\Scouting\Processors\Statistic;
use Closure;

class SecondPlays
{
    const SECOND_PLAY_WON_SIDE_EFFECT = 'SECOND_PLAY_WON_SIDE_EFFECT';
    const SECOND_PLAY_LOST_SIDE_EFFECT = 'SECOND_PLAY_LOST_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_second_plays';

    /**
     * Processor used for calculate the total throws in
     * (won and lost) by the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $second_plays_won = $stats->activitiesFromSideEffect(self::SECOND_PLAY_WON_SIDE_EFFECT);
        $second_plays_lost = $stats->activitiesFromSideEffect(self::SECOND_PLAY_LOST_SIDE_EFFECT);
        $total_second_plays = count($second_plays_won['own']) + count($second_plays_lost['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_second_plays);

        return $next($stats);
    }
}
