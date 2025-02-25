<?php

namespace Modules\Scouting\Processors\SideEffects\FieldHockey;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Cards
{
    const SIDE_EFFECT = 'CARD_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'total_cards';
    const STATISTIC_NAME_RIVAL = 'total_rival_cards';

    /**
     * Processor used for calculate the total cards
     * of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $cards = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $stats->setStatistic(self::STATISTIC_NAME_OWN, count($cards['own']));
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, count($cards['rival']));

        return $next($stats);
    }
}
