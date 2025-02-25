<?php

namespace Modules\Scouting\Processors\SideEffects\Badminton;

use Modules\Scouting\Processors\SideEffects\Badminton\PointsByWinnerShots;
use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\SideEffects\Badminton\PointsError;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\Statistic;
use Closure;

class Calculate
{
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
                $this->point($activity, $stats);
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
    public function point($activity, $stats)
    {
        $side_effect = $activity->action->side_effect;

        switch (true) {
            case $side_effect == PointsError::POINT_ERROR_SIDE_EFFECT || ($side_effect == Shots::SHOT_SIDE_EFFECT && $activity->custom_params == ScoutingActivity::WINNER):
                $this->errorSideEffect($activity, $stats);
                break;

            case $side_effect == PointsByWinnerShots::POINT_SIDE_EFFECT || ($side_effect == Shots::SHOT_SIDE_EFFECT && $activity->custom_params == ScoutingActivity::WINNER):
                $this->pointSideEffect($activity, $stats);
                break;
        }
    }

    /**
     * Determinate if the current activity is a error
     *
     * @param ScoutingActivity $activity
     * @param $stats
     * @return array
     */
    private function errorSideEffect($activity, $stats)
    {
        $stats->score->addToRival(1);
    }

     /**
     * Determinate if the current activity is a point
     *
     * @param ScoutingActivity $activity
     * @param $stats
     * @return array
     */
    private function pointSideEffect($activity, $stats)
    {
        if ($activity->action->rival_team_action) {
            $stats->score->addToRival(1);
        } else {
            $stats->score->addToOwn(1);
        }
    }
}