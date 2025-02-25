<?php

namespace Modules\Scouting\Processors\SideEffects\General;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Substitution
{
    const SIDE_EFFECT = 'SUBSTITUTION_SIDE_EFFECT';
    const STATISTIC_NAME = 'number_of_substitutions';

    /**
     * Processor used for substitute a player
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $substitutions_activities = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $total_substitutions = count($substitutions_activities['own']);

        collect($substitutions_activities['own'])->each(function ($substitution) use ($stats) {
            $stats->substitution($substitution->custom_params, $substitution->in_game_time);
        });

        $stats->setStatistic(self::STATISTIC_NAME, $total_substitutions);

        return $next($stats);
    }
}
