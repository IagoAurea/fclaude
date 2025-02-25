<?php

namespace Modules\Scouting\Processors\SideEffects\Padel;

use Modules\Scouting\Processors\Statistic;
use Closure;

class AccountStatistic
{
    /**
     * Processor used for accounting the
     * statistics for the own team on
     * a tennis match
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $activities = $stats->activitiesFromActions();

        foreach ($activities as $key => $activity) {
            $stats->setStatistic($key, count($activity['own']) > 0 ? count($activity['own']) : count($activity['rival']) );
        }

        return $next($stats);
    }
}
