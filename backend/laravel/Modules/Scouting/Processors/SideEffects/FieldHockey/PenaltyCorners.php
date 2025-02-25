<?php

namespace Modules\Scouting\Processors\SideEffects\FieldHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class PenaltyCorners
{
    const PENALTY_CORNER_SCORED_SIDE_EFFECT = 'PENALTY_CORNER_SCORED_SIDE_EFFECT';
    const PENALTY_CORNER_MISSED_SIDE_EFFECT = 'PENALTY_CORNER_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_penalty_corners';
    const STATISTIC_NAME_RIVAL = 'total_rival_penalty_corners';

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
        $penalty_corners_scored = $stats->activitiesFromSideEffect(self::PENALTY_CORNER_SCORED_SIDE_EFFECT);
        $penalty_corners_missed = $stats->activitiesFromSideEffect(self::PENALTY_CORNER_MISSED_SIDE_EFFECT);

        $total_penalty_corners_won = count($penalty_corners_scored['own']) + count($penalty_corners_missed['own']);
        $total_penalty_corners_rival = count($penalty_corners_scored['rival']) + count($penalty_corners_missed['rival']);

        $stats->score->addToOwn(count($penalty_corners_scored['own']));
        $stats->score->addToRival(count($penalty_corners_scored['rival']));

        $stats->setStatistic(self::STATISTIC_NAME_OWN, $total_penalty_corners_won);
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, $total_penalty_corners_rival);

        return $next($stats);
    }
}
