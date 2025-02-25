<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Points
{
    const ONE_POINT_SIDE_EFFECT = 'ONE_POINT_SIDE_EFFECT';
    const TWO_POINT_SIDE_EFFECT = 'TWO_POINT_SIDE_EFFECT';
    const THREE_POINT_SIDE_EFFECT = 'THREE_POINT_SIDE_EFFECT';

    /**
     * Processor used for calculate the score
     * for own and rival team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $one_point = $stats->activitiesFromSideEffect(self::ONE_POINT_SIDE_EFFECT);
        $two_point = $stats->activitiesFromSideEffect(self::TWO_POINT_SIDE_EFFECT);
        $three_point = $stats->activitiesFromSideEffect(self::THREE_POINT_SIDE_EFFECT);

        $stats->score->addToOwn(count($one_point['own']));
        $stats->score->addToOwn(count($two_point['own']), 2);
        $stats->score->addToOwn(count($three_point['own']), 3);

        $stats->score->addToRival(count($one_point['rival']));
        $stats->score->addToRival(count($two_point['rival']), 2);
        $stats->score->addToRival(count($three_point['rival']), 3);

        return $next($stats);
    }
}
