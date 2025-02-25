<?php

namespace Modules\Scouting\Processors\SideEffects\IceHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Goals
{
    const SIDE_EFFECT = 'GOAL_SIDE_EFFECT';

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
        $goals = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);

        $stats->score->addToOwn(count($goals['own']));
        $stats->score->addToRival(count($goals['rival']));

        return $next($stats);
    }
}
