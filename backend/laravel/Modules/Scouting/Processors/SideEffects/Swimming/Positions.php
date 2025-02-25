<?php

namespace Modules\Scouting\Processors\SideEffects\Swimming;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Positions
{
    const FIRST_SIDE_EFFECT = 'FIRST_SIDE_EFFECT';
    const SECOND_SIDE_EFFECT = 'SECOND_SIDE_EFFECT';
    const THIRD_SIDE_EFFECT = 'THIRD_SIDE_EFFECT';
    const FOUR_SIDE_EFFECT = 'FOUR_SIDE_EFFECT';
    const FIFTH_SIDE_EFFECT = 'FIFTH_SIDE_EFFECT';
    const SIXTH_SIDE_EFFECT = 'SIXTH_SIDE_EFFECT';
    const SEVENTH_SIDE_EFFECT = 'SEVENTH_SIDE_EFFECT';
    const EIGHTH_SIDE_EFFECT = 'EIGHTH_SIDE_EFFECT';

    /**
     * Processor used for calculate the score
     * for own and rival team
     *
     * @param Statistic $stats
     * @param int $amount
     * @return Closure
     */
    public function handle(Statistic $stats, $amount)
    {
        $stats->score->addToOwn($amount);

        return $stats;;
    }
}
