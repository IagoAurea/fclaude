<?php

namespace Modules\Scouting\Processors\SideEffects\Swimming;

use Modules\Scouting\Processors\Statistic;
use Closure;

class AccountStatistic
{
    /**
     * Processor used for accounting the
     * statistics for the own team on
     * a football match
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $activities = $stats->activitiesFromActions();
        $actions_to_not_account = $this->actionsToNotAccount();

        foreach ($activities as $key => $activity) {
            if (!in_array($key, $actions_to_not_account)) {
                $stats->setStatistic($key, count($activity['own']) > 0 ? count($activity['own']) : count($activity['rival']));
            }
        }

        return $next($stats);
    }

    /**
     * The actions that will not be taking
     * into account for the statistics
     *
     * @return array
     */
    private function actionsToNotAccount()
    {
        return [];
    }
}
