<?php

namespace Modules\Scouting\Processors\SideEffects\AmericanSoccer;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Yards
{
    const TEN_YARDS_WON_SIDE_EFFECT = 'TEN_YARDS_WON_SIDE_EFFECT';
    const TEN_YARDS_LOST_SIDE_EFFECT = 'TEN_YARDS_LOST_SIDE_EFFECT';
    const TWENTY_YARDS_WON_SIDE_EFFECT = 'TWENTY_YARDS_WON_SIDE_EFFECT';
    const TWENTY_YARDS_LOST_SIDE_EFFECT = 'TWENTY_YARDS_LOST_SIDE_EFFECT';
    const FIFTY_YARDS_WON_SIDE_EFFECT = 'FIFTY_YARDS_WON_SIDE_EFFECT';
    const FIFTY_YARDS_LOST_SIDE_EFFECT = 'FIFTY_YARDS_LOST_SIDE_EFFECT';

    const STATISTIC_YARD_WON_NAME = 'total_yards_won';
    const STATISTIC_YARD_LOST_NAME = 'total_yards_lost';

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
        $ten_yards_won_activities = $stats->activitiesFromSideEffect(self::TEN_YARDS_WON_SIDE_EFFECT);
        $ten_yards_lost_activities = $stats->activitiesFromSideEffect(self::TEN_YARDS_LOST_SIDE_EFFECT);

        $ten_yards_won = count($ten_yards_won_activities['own']) * 10;
        $ten_yards_lost = count($ten_yards_lost_activities['own']) * 10;

        $twenty_yards_won_activities = $stats->activitiesFromSideEffect(self::TWENTY_YARDS_WON_SIDE_EFFECT);
        $twenty_yards_lost_activities = $stats->activitiesFromSideEffect(self::TWENTY_YARDS_LOST_SIDE_EFFECT);

        $twenty_yards_won = count($twenty_yards_won_activities['own']) * 20;
        $twenty_yards_lost = count($twenty_yards_lost_activities['own']) * 20;

        $fifty_yards_won_activities = $stats->activitiesFromSideEffect(self::FIFTY_YARDS_WON_SIDE_EFFECT);
        $fifty_yards_lost_activities = $stats->activitiesFromSideEffect(self::FIFTY_YARDS_LOST_SIDE_EFFECT);

        $fifty_yards_won = count($fifty_yards_won_activities['own']) * 50;
        $fifty_yards_lost = count($fifty_yards_lost_activities['own']) * 50;

        $total_yards_won = $ten_yards_won  + $twenty_yards_won + $fifty_yards_won;
        $total_yards_lost = $ten_yards_lost + $twenty_yards_lost + $fifty_yards_lost;

        $stats->setStatistic(self::STATISTIC_YARD_WON_NAME, $total_yards_won);
        $stats->setStatistic(self::STATISTIC_YARD_LOST_NAME, $total_yards_lost);

        return $next($stats);
    }
}
