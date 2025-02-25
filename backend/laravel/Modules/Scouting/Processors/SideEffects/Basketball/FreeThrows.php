<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class FreeThrows
{
    const FREE_THROW_SCORED_SIDE_EFFECT = 'FREE_THROW_SCORED_SIDE_EFFECT';
    const FREE_THROW_MISSED_SIDE_EFFECT = 'FREE_THROW_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_free_throws';

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
        $free_throws_scored = $stats->activitiesFromSideEffect(self::FREE_THROW_SCORED_SIDE_EFFECT);
        $free_throws_missed = $stats->activitiesFromSideEffect(self::FREE_THROW_MISSED_SIDE_EFFECT);

        $total_free_throws = count($free_throws_scored['own']) + count($free_throws_missed['own']);
        
        $stats->score->addToOwn(count($free_throws_scored['own']));
        $stats->score->addToRival(count($free_throws_scored['rival']));

        $stats->setStatistic(self::STATISTIC_NAME, $total_free_throws);

        return $next($stats);
    }
}
