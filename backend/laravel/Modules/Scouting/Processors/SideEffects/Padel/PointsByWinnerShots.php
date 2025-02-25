<?php

namespace Modules\Scouting\Processors\SideEffects\Padel;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\Statistic;
use Closure;

class PointsByWinnerShots
{
    const POINT_SIDE_EFFECT = 'POINT_SIDE_EFFECT';
    const WINNER_STATISTIC_NAME = 'total_winner_shots';

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
            $activities->each(function ($activity) use ($stats) {
                if ($this->point($activity)) {
                    if ($activity->action->rival_team_action) {
                        $stats->score->addToRival(1);
                    } else {
                        $stats->score->addToOwn(1);
                        if ($activity->action->side_effect == Shots::SHOT_SIDE_EFFECT) {
                            $stats->increaseStatistic(self::WINNER_STATISTIC_NAME);
                        }
                    }
                }
            });
        } catch (MatchAlreadyHasAWinnerException $exception) {
            return $next($stats);
        }

        return $next($stats);
    }

    /**
     * Determinate if the current activity is a point activity
     *
     * @param ScoutingActivity $activity
     * @return bool
     */
    public function point($activity)
    {
        $side_effect = $activity->action->side_effect;

        return $side_effect == self::POINT_SIDE_EFFECT || ($side_effect == Shots::SHOT_SIDE_EFFECT && $activity->custom_params == ScoutingActivity::WINNER);
    }
}
