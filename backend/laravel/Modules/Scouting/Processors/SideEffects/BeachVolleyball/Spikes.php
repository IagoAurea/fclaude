<?php

namespace Modules\Scouting\Processors\SideEffects\BeachVolleyball;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Spikes
{
    const SPIKE_SIDE_EFFECT = 'SPIKE_SIDE_EFFECT';
    
    const SPIKE_POINT = 'spike_point';
    const SPIKE_ERROR = 'spike_error';

    const STATISTIC_NAME = 'total_spikes';

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
        
        $serves = $stats->activitiesFromSideEffect(self::SPIKE_SIDE_EFFECT);

        try {
            $activities->each(function($activity) use ($stats){
                if ($activity->action->code == self::SPIKE_POINT) {
                    $stats->score->addToOwn(1);
                }

                if ($activity->action->code == self::SPIKE_ERROR) {
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
