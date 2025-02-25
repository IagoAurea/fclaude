<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class FieldGoals
{
    const FIELD_GOAL_SCORED_SIDE_EFFECT = 'FIELD_GOAL_SCORED_SIDE_EFFECT';
    const FIELD_GOAL_MISSED_SIDE_EFFECT = 'FIELD_GOAL_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_field_goals_attempts';

    /**
     * Processor used for calculate the total conversions
     * (missed and scored) and add the points to the
     * score
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $field_goals_scored = $stats->activitiesFromSideEffect(self::FIELD_GOAL_SCORED_SIDE_EFFECT);
        $field_goals_missed = $stats->activitiesFromSideEffect(self::FIELD_GOAL_MISSED_SIDE_EFFECT);

        $stats->score->addToOwn(count($field_goals_scored['own']), 3);
        $stats->score->addToRival(count($field_goals_scored['rival']), 3);

        $total_field_goals = count($field_goals_scored['own']) + count($field_goals_missed['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_field_goals);

        return $next($stats);
    }
}
