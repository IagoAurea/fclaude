<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Digs
{
    const DIG_SIDE_EFFECT = 'DIG_SIDE_EFFECT';

    const DIG_ERRORS = 'dig_errors';

    const STATISTIC_NAME = 'total_digs';

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
        $activities = $stats->activitiesOrderedByTime();

        $serves = $stats->activitiesFromSideEffect(self::DIG_SIDE_EFFECT);

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->code == self::DIG_ERRORS) {
                    $stats->score->addToRival(1);
                }
            });
        } catch (MatchAlreadyHasAWinnerException $exception) {
            return $next($stats);
        }

        $stats->setStatistic(self::STATISTIC_NAME, count($serves['own']));

        return $next($stats);
    }
}
