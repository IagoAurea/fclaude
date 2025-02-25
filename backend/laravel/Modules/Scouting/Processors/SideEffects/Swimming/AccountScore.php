<?php

namespace Modules\Scouting\Processors\SideEffects\Swimming;

use Modules\Scouting\Processors\SideEffects\Swimming\Positions;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\Statistic;
use Closure;

class AccountScore
{
    const HANDLERS = [
        Positions::FIRST_SIDE_EFFECT => 1,
        Positions::SECOND_SIDE_EFFECT => 2,
        Positions::THIRD_SIDE_EFFECT => 3,
        Positions::FOUR_SIDE_EFFECT => 4,
        Positions::FIFTH_SIDE_EFFECT => 5,
        Positions::SIXTH_SIDE_EFFECT => 6,
        Positions::SEVENTH_SIDE_EFFECT => 7,
        Positions::EIGHTH_SIDE_EFFECT => 8,
    ];

    /**
     * * Handlers for the activity performed per turn
     *
     * @param $handlers
     */
    protected $handlers;

    /**
     * * Statistics
     *
     * @param $stats
     */
    protected $stats;

    /**
     * * AccountScore constructor
     */
    public function __construct()
    {
        $this->handlers = self::HANDLERS;
        $this->stats;
    }

    /**
     * * Processor used for accounting the
     * * score for every turn taken in
     * * a baseball match
     *
     * @param Statistic $stats
     * @param Closure $next
     * @return Closure
     */
    public function handle(Statistic $stats, Closure $next)
    {
        $this->stats = $stats;
        $activities = $this->stats->activitiesOrderedByTime();

        $activities->each(function ($activity) {
            if (isset($activity->action->side_effect)) {
                $this->process($activity);
            }
        });

        return $next($stats);
    }

    /**
     * * Used to decide how to manage an activity
     *
     * @param ScoutingActivity $activity
     */
    private function process(ScoutingActivity $activity)
    {
        if (isset($this->handlers[$activity->action->side_effect])) {
            $amount = $this->handlers[$activity->action->side_effect];
            $this->stats = app(Positions::class)->handle($this->stats, $amount);
        }
    }
}
