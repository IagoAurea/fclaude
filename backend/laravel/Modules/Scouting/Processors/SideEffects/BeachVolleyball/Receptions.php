<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Receptions
{
    const RECEPTION_SIDE_EFFECT = 'RECEPTION_SIDE_EFFECT';

    const RECEPTION_ERRORS = 'reception_errors';

    const STATISTIC_NAME = 'total_receptions';

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

        $serves = $stats->activitiesFromSideEffect(self::RECEPTION_SIDE_EFFECT);

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->code == self::RECEPTION_ERRORS) {
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
