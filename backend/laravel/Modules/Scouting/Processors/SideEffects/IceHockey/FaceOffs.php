<?php

namespace Modules\Scouting\Processors\SideEffects\IceHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class FaceOffs
{
    const FACE_OFF_WON_TARGET_SIDE_EFFECT = 'FACE_OFF_WON_TARGET_SIDE_EFFECT';
    const FACE_OFF_LOST_TARGET_SIDE_EFFECT = 'FACE_OFF_LOST_TARGET_SIDE_EFFECT';
    const STATISTIC_NAME = 'total_face_offs';

    /**
     * Processor used for calculate the total throws
     * (on target + off target) of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $face_off_won_target = $stats->activitiesFromSideEffect(self::FACE_OFF_WON_TARGET_SIDE_EFFECT);
        $face_off_lost_target = $stats->activitiesFromSideEffect(self::FACE_OFF_LOST_TARGET_SIDE_EFFECT);
        $total_face_offs = count($face_off_won_target['own']) + count($face_off_lost_target['own']);

        $stats->setStatistic(self::STATISTIC_NAME, $total_face_offs);

        return $next($stats);
    }
}
