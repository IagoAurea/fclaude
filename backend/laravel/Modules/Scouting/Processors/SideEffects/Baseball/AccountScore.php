<?php

namespace Modules\Scouting\Processors\SideEffects\Baseball;

use Modules\Scouting\Processors\SideEffects\Baseball\Strikes;
use Modules\Scouting\Processors\SideEffects\Baseball\Batter;
use Modules\Scouting\Processors\SideEffects\Baseball\Runs;
use Modules\Scouting\Processors\SideEffects\Baseball\Balls;
use Modules\Scouting\Processors\SideEffects\Baseball\Walks;
use Modules\Scouting\Processors\SideEffects\Baseball\Errors;
use Modules\Scouting\Processors\SideEffects\Baseball\Outs;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\Statistic;
use Closure;

class AccountScore
{
    const HANDLERS = [
        Strikes::SIDE_EFFECT => Strikes::class,
        Runs::SIDE_EFFECT => Runs::class,
        Balls::SIDE_EFFECT => Balls::class,
        Walks::SIDE_EFFECT => Walks::class,
        Errors::SIDE_EFFECT => Errors::class,
        Outs::SIDE_EFFECT => Outs::class,
        Batter::SIDE_EFFECT => Batter::class
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
            $handler = $this->handlers[$activity->action->side_effect];
            $this->stats = app($handler)->handle($this->stats, $activity);
        }
    }
}
