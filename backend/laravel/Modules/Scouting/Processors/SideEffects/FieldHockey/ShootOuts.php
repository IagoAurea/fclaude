<?php

namespace Modules\Scouting\Processors\SideEffects\FieldHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class ShootOuts
{
    const SHOOT_OUT_SCORED_SIDE_EFFECT = 'SHOOT_OUT_SCORED_SIDE_EFFECT';
    const SHOOT_OUT_MISSED_SIDE_EFFECT = 'SHOOT_OUT_MISSED_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_shoot_outs';
    const STATISTIC_NAME_RIVAL = 'total_rival_shoot_outs';

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
        $shoot_outs_scored = $stats->activitiesFromSideEffect(self::SHOOT_OUT_SCORED_SIDE_EFFECT);
        $shoot_outs_missed = $stats->activitiesFromSideEffect(self::SHOOT_OUT_MISSED_SIDE_EFFECT);

        $total_shoot_outs_won = count($shoot_outs_scored['own']) + count($shoot_outs_missed['own']);
        $total_shoot_outs_rival = count($shoot_outs_scored['rival']) + count($shoot_outs_missed['rival']);

        $stats->score->addToOwn(count($shoot_outs_scored['own']));
        $stats->score->addToRival(count($shoot_outs_scored['rival']));

        $stats->setStatistic(self::STATISTIC_NAME_OWN, $total_shoot_outs_won);
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, $total_shoot_outs_rival);

        return $next($stats);
    }
}
