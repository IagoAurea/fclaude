<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Blocks
{
    const BLOCK_SIDE_EFFECT = 'BLOCK_SIDE_EFFECT';

    const BLOCK_POINTS = 'block_points';
    const BLOCK_ERRORS = 'block_errors';

    const STATISTIC_NAME = 'total_blocks';

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

        $serves = $stats->activitiesFromSideEffect(self::BLOCK_SIDE_EFFECT);

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->code == self::BLOCK_POINTS) {
                    $stats->score->addToOwn(1);
                }

                if ($activity->action->code == self::BLOCK_ERRORS) {
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
