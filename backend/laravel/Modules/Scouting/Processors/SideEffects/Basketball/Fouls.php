<?php

namespace Modules\Scouting\Processors\SideEffects\Basketball;

use Modules\Scouting\Processors\Statistic;
use Closure;

class Fouls
{
    const SIDE_EFFECT = 'FOUL_SIDE_EFFECT';
    const STATISTIC_NAME_OWN = 'commited_fouls';
    const STATISTIC_NAME_RIVAL = 'rival_fouls';

    const STATISTIC_NAME_FOULS = 'fouls';
    const STATISTIC_NAME_PERSONAL_FOULS = 'personal_fouls';
    const STATISTIC_NAME_TECHNICAL_FOULS = 'technical_fouls';
    const STATISTIC_NAME_UNSPORTSMANLIKE_FOULS = 'unsportsmanlike_fouls';
    const STATISTIC_NAME_FOULS_COMMITTED = 'fouls_committed';
    const STATISTIC_NAME_FOULS_RECEIVED = 'fouls_received';

    const STATISTIC_NAME_TOTAL_FOULS = 'total_fouls';
    const STATISTIC_NAME_TOTAL_FOULS_RIVALS = 'total_fouls_rival';

     /**
     * * Variable
     *
     * @var $types
     */
    private $types = [
        self::STATISTIC_NAME_FOULS_COMMITTED => 0,
        self::STATISTIC_NAME_FOULS => 0,
        self::STATISTIC_NAME_PERSONAL_FOULS => 0,
        self::STATISTIC_NAME_TECHNICAL_FOULS => 0,
        self::STATISTIC_NAME_UNSPORTSMANLIKE_FOULS => 0,
        self::STATISTIC_NAME_RIVAL => 0,
        self::STATISTIC_NAME_FOULS_RECEIVED => 0
    ];

    /**
     * Processor used for calculate the total fouls
     * of the own team
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $fouls = $stats->activitiesFromSideEffect(self::SIDE_EFFECT);
        $stats->setStatistic(self::STATISTIC_NAME_OWN, count($fouls['own']));
        $stats->setStatistic(self::STATISTIC_NAME_RIVAL, count($fouls['rival']));

        $this->sumTotalsFouls($fouls['own']);

        $this->sumTotalsFouls($fouls['rival']);

        $total_foults =  $this->types[self::STATISTIC_NAME_FOULS_COMMITTED] + $this->types[self::STATISTIC_NAME_FOULS] +
            $this->types[self::STATISTIC_NAME_PERSONAL_FOULS] + $this->types[self::STATISTIC_NAME_TECHNICAL_FOULS] +
            $this->types[self::STATISTIC_NAME_UNSPORTSMANLIKE_FOULS];

        $stats->setStatistic(self::STATISTIC_NAME_TOTAL_FOULS, $total_foults);

        $total_foults_rivals = $this->types[self::STATISTIC_NAME_FOULS_RECEIVED] +
            $this->types[self::STATISTIC_NAME_RIVAL];

        $stats->setStatistic(self::STATISTIC_NAME_TOTAL_FOULS_RIVALS, $total_foults_rivals);

        return $next($stats);
    }

    /**
     * Function allow sum totals fouls
     */
    private function sumTotalsFouls($fouls)
    {
        foreach($fouls as $foul) {
            $action_code = $foul['action']['code'];

            $this->types[$action_code] = $this->types[$action_code ] + 1;
        }
    }
}
