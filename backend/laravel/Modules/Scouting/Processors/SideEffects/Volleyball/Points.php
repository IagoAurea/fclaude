<?php

namespace Modules\Scouting\Processors\SideEffects\Volleyball;

use Modules\Scouting\Processors\SideEffects\Volleyball\Receptions;
use Modules\Scouting\Processors\SideEffects\Volleyball\FootKicks;
use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\SideEffects\Volleyball\Blocks;
use Modules\Scouting\Processors\SideEffects\Volleyball\Spikes;
use Modules\Scouting\Processors\SideEffects\Volleyball\Serves;
use Modules\Scouting\Processors\SideEffects\Volleyball\Digs;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Points
{
    const POINT_WON_SIDE_EFFECT = 'POINT_WON_SIDE_EFFECT';
    const POINT_LOST_SIDE_EFFECT = 'POINT_LOST_SIDE_EFFECT';

    const ACTIONS_ADDITIONAL = [
        FootKicks::FOOT_KICK_ERROR => FootKicks::STATISTIC_NAME,
        Digs::DIG_ERRORS => Digs::STATISTIC_NAME,
        Receptions::RECEPTION_ERRORS => Receptions::STATISTIC_NAME,
        Blocks::BLOCK_ERRORS => Blocks::STATISTIC_NAME,
        Blocks::BLOCK_POINTS => Blocks::STATISTIC_NAME,
        Spikes::SPIKE_ERROR => Spikes::STATISTIC_NAME,
        Spikes::SPIKE_POINT => Spikes::STATISTIC_NAME,
        Serves::SERVER_ERRORS => Serves::STATISTIC_NAME,
        Serves::SERVER_POINTS => Serves::STATISTIC_NAME
    ];

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
                    
                    if(isset(self::ACTIONS_ADDITIONAL[$activity->action->code])) {
                        $stats->increaseStatistic(self::ACTIONS_ADDITIONAL[$activity->action->code]);
                    }
                } elseif($activity->action->side_effect == self::POINT_LOST_SIDE_EFFECT) {
                    if (! $activity->action->rival_team_action) {
                        $stats->score->addToRival(1);
                    } else {
                        $stats->score->addToOwn(1);
                    }

                    if(isset(self::ACTIONS_ADDITIONAL[$activity->action->code])) {
                        $stats->increaseStatistic(self::ACTIONS_ADDITIONAL[$activity->action->code]);
                    }
                }
            });
        } catch (MatchAlreadyHasAWinnerException $exception) {
            return $next($stats);
        }

        return $next($stats);
    }
}
