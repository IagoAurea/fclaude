<?php

namespace Modules\Scouting\Processors\SideEffects\FieldHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class PenaltyStrokes
{
    const PENALTY_STROKE_SCORED_SIDE_EFFECT = 'PENALTY_STROKE_SCORED_SIDE_EFFECT';
    const PENALTY_STROKE_MISSED_SIDE_EFFECT = 'PENALTY_STROKE_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_penalty_strokes';
    const STATISTIC_NAME_RIVAL = 'total_rival_penalty_strokes';

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
        $penalty_strokes_scored = $stats->activitiesFromSideEffect(self::PENALTY_STROKE_SCORED_SIDE_EFFECT);
        $penalty_strokes_missed = $stats->activitiesFromSideEffect(self::PENALTY_STROKE_MISSED_SIDE_EFFECT);

        $total_penalty_strokes_won = count($penalty_strokes_scored['own']) + count($penalty_strokes_missed['own']);
        $total_penalty_strokes_rival = count($penalty_strokes_scored['rival']) + count($penalty_strokes_missed['rival']);

        $stats->score->addToOwn(count($penalty_strokes_scored['own']));
        $stats->score->addToRival(count($penalty_strokes_scored['rival']));

        $stats->setStatistic(self::STATISTIC_NAME_OWN, $total_penalty_strokes_won);
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, $total_penalty_strokes_rival);

        return $next($stats);
    }
}
