<?php

namespace Modules\Scouting\Processors\SideEffects\Cricket;

use Modules\Scouting\Processors\SideEffects\Cricket\Runs;
use Modules\Scouting\Processors\SideEffects\Cricket\Outs;
use Modules\Scouting\Processors\SideEffects\Cricket\Overs;
use Modules\Scouting\Processors\SideEffects\Cricket\FourRuns;
use Modules\Scouting\Processors\SideEffects\Cricket\SixRuns;
use Modules\Scouting\Processors\SideEffects\Cricket\ExtraPoints;
use Modules\Scouting\Processors\SideEffects\Cricket\HalfCentury;
use Modules\Scouting\Processors\SideEffects\Cricket\Century;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\Statistic;
use Closure;

class AccountScore
{
    const HANDLERS = [
        Runs::SIDE_EFFECT => Runs::class,
        FourRuns::SIDE_EFFECT => FourRuns::class,
        SixRuns::SIDE_EFFECT => SixRuns::class,
        ExtraPoints::SIDE_EFFECT => ExtraPoints::class,
        HalfCentury::SIDE_EFFECT => HalfCentury::class,
        Century::SIDE_EFFECT => Century::class,
        Outs::SIDE_EFFECT => Outs::class,
        Overs::SIDE_EFFECT => Overs::class,
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
