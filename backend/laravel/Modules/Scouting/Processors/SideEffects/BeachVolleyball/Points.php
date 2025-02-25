<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Points
{
    const POINT_WON_SIDE_EFFECT = 'POINT_WON_SIDE_EFFECT';
    const POINT_LOST_SIDE_EFFECT = 'POINT_LOST_SIDE_EFFECT';

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

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->side_effect == self::POINT_WON_SIDE_EFFECT) {
                    if (! $activity->action->rival_team_action) {
                        $stats->score->addToOwn(1);
                    } else {
                        $stats->score->addToRival(1);
                    }
                } elseif($activity->action->side_effect == self::POINT_LOST_SIDE_EFFECT) {
                    if (! $activity->action->rival_team_action) {
                        $stats->score->addToRival(1);
                    } else {
                        $stats->score->addToOwn(1);
                    }
                }
            });
        } catch (MatchAlreadyHasAWinnerException $exception) {
            return $next($stats);
        }

        return $next($stats);
    }
}
