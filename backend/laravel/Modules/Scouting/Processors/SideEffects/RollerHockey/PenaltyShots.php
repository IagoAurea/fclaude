<?php

namespace Modules\Scouting\Processors\SideEffects\RollerHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class PenaltyShots
{
    const PENALTY_SHOT_SCORED_SIDE_EFFECT = 'PENALTY_SHOT_SCORED_SIDE_EFFECT';
    const PENALTY_SHOT_MISSED_SIDE_EFFECT = 'PENALTY_SHOT_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_penalty_shots';
    const STATISTIC_NAME_RIVAL = 'total_rival_penalty_shots';

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
        $penalty_shots_scored = $stats->activitiesFromSideEffect(self::PENALTY_SHOT_SCORED_SIDE_EFFECT);
        $penalty_shots_missed = $stats->activitiesFromSideEffect(self::PENALTY_SHOT_MISSED_SIDE_EFFECT);

        $total_penalty_shots_won = count($penalty_shots_scored['own']) + count($penalty_shots_missed['own']);
        $total_penalty_shots_rival = count($penalty_shots_scored['rival']) + count($penalty_shots_missed['rival']);

        $stats->score->addToOwn(count($penalty_shots_scored['own']));
        $stats->score->addToRival(count($penalty_shots_scored['rival']));

        $stats->setStatistic(self::STATISTIC_NAME_OWN, $total_penalty_shots_won);
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, $total_penalty_shots_rival);

        return $next($stats);
    }
}
