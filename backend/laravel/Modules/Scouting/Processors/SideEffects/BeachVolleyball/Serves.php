<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Serves
{
    const SERVE_SIDE_EFFECT = 'SERVE_SIDE_EFFECT';

    const SERVER_POINTS = 'serve_points';
    const SERVER_ERRORS = 'serve_errors';

    const STATISTIC_NAME = 'total_serves';

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

        $serves = $stats->activitiesFromSideEffect(self::SERVE_SIDE_EFFECT);

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->code == self::SERVER_POINTS) {
                    $stats->score->addToOwn(1);
                }

                if ($activity->action->code == self::SERVER_ERRORS) {
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
