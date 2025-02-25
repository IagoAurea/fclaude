<?php

namespace Modules\Scouting\Processors\SideEffects\FieldHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Autogoals
{
    const SIDE_EFFECT = 'AUTOGOAL_SIDE_EFFECT';

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
        $autogoals = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);

        $stats->score->addToOwn(count($autogoals['rival']));
        $stats->score->addToRival(count($autogoals['own']));

        return $next($stats);
    }
}
