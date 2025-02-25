<?php

namespace Modules\Scouting\Processors;

use Modules\Scouting\Processors\Score\ScoreInterface;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Entities\Action;
use Modules\Sport\Entities\Sport;

class Statistic
{
    const UNCLASSIFIED_SIDE_EFFECT = 'UNCLASSIFIED';

    /**
     * The score of the game
     *
     * @var Sport $sport
     */
    public $sport;

    /**
     * The score of the game
     *
     * @var Score
     */
    public $score;

    /**
     * The activities associated to
     * perform the calculations
     *
     * @var Collection
     */
    protected $activities;

    /**
     * The activities grouped by
     * action name
     *
     * @var array
     */
    protected $actions;

    /**
     * The processed sttistics
     *
     * @var array
     */
    protected $statistics;

    /**
     * The processed substitution
     *
     * @var array
     */
    protected $substitutions;

    /**
     * The activities grouped by
     * the side effect
     *
     * @var array
     */
    protected $side_effects;

    /**
     * Statistic constructor
     * @param Collection $activities
     * @param ScoreInterface $score
     */
    public function __construct($activities, ScoreInterface $score, Sport $sport)
    {
        $this->activities = $activities;
        $this->score = $score;
        $this->sport = $sport;
        $this->actions = [];
        $this->statistics = [];
        $this->side_effects = [];
        $this->substitutions = [];

        $this->classifyActivities();
    }

    /**
     * Getter for the activities
     * grouped by actions
     *
     * @param ScoutingActivity $activity
     * @return array
     */
    public function activitiesFromActions()
    {
        return $this->actions;
    }

    /**
     * Getter for the activities associated
     * with a side effect
     *
     * @param string $side_effect
     * @return array
     */
    public function activitiesFromSideEffect($side_effect)
    {
        if (!isset($this->side_effects[$side_effect])) {
            return [
                'own' => [],
                'rival' => []
            ];
        }

        return $this->side_effects[$side_effect];
    }

    /**
     * Getter for the activities ordered by time
     *
     * @return array
     */
    public function activitiesOrderedByTime()
    {
        return $this->activities;
    }

    /**
     * Setter for the statistics
     *
     * @param string $name
     * @param mixed $value
     * @return Statistic
     */
    public function setStatistic($name, $value)
    {
        $this->statistics[$name] = $value;

        return $this;
    }

    /**
     * Substitute a player
     *
     * @param string $data
     * @param int $in_game_time
     * @return Statistic
     */
    public function substitution($data, $in_game_time)
    {
        $this->substitutions[] = [
            'data' => json_decode($data),
            'time' => $in_game_time,
        ];

        return $this;
    }

    /**
     * Setter for the statistics
     *
     * @param string $name
     * @param mixed $value
     * @return Statistic
     */
    public function increaseStatistic($name, $value = 1)
    {
        if (!isset($this->statistics[$name])) {
            $this->statistics[$name] = $value;
            return $this;
        }

        $this->statistics[$name] += $value;

        return $this;
    }

    /**
     * Getter for a statistic by name
     *
     * @param string $name
     * @return mixed
     */
    public function getStatistic($name)
    {
        if (!isset($this->statistics[$name])) {
            return null;
        }

        return $this->statistics[$name];
    }

    /**
     * Getter for the statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * Getter for the results
     *
     * @return array
     */
    public function getResults($all)
    {
        $results = [
            'score' => $this->score->getScore(),
            'substitutions' => $this->substitutions,
        ];

        if ($all) {
            $results['statistics'] = $this->statistics;
        }

        return $results;
    }

    /**
     * Get the side effect associated
     * with an activity
     *
     * @param ScoutingActivity $activity
     * @return string
     */
    private function getSideEffect(ScoutingActivity $activity)
    {
        if (!isset($activity->action->side_effect)) {
            return self::UNCLASSIFIED_SIDE_EFFECT;
        }

        return $activity->action->side_effect;
    }

    /**
     * It cycles through the activities
     * classifying them by side effect
     * and by action
     *
     * @return void
     */
    private function classifyActivities()
    {
        $actions = Action::where(['sport_id' => $this->sport->id])->get();

        $actions->each(function ($action) {
            if (!isset($this->actions[$action->code])) {
                $this->actions[$action->code] = [
                    'own' => [],
                    'rival' => []
                ];
            }
        });
        $this->activities->each(function ($activity) {
            $this->classifyActivity($activity);
        });
    }

    /**
     * It classifies an activity by
     * side effect and by action
     *
     * @param ScoutingActivity $activity
     * @return void
     */
    private function classifyActivity(ScoutingActivity $activity)
    {
        $this->classifyBySideEffect($activity, $this->getSideEffect($activity));
        $this->classifyByActionName($activity);
    }

    /**
     * It classifies an activity by
     * side effect
     *
     * @param Collection $activity
     * @param string $side_effect
     * @return void
     */
    private function classifyBySideEffect(ScoutingActivity $activity, $side_effect)
    {
        if (!isset($this->side_effects[$side_effect])) {
            $this->side_effects[$side_effect] = [
                'own' => [],
                'rival' => []
            ];
        }

        if ($activity->action->rival_team_action) {
            array_push($this->side_effects[$side_effect]['rival'], $activity);
        } else {
            array_push($this->side_effects[$side_effect]['own'], $activity);
        }
    }

    /**
     * It classifies an activity by
     * side effect
     *
     * @param ScoutingActivity $activity
     * @return void
     */
    private function classifyByActionName(ScoutingActivity $activity)
    {
        if (!isset($this->actions[$activity->action->code])) {
            $this->actions[$activity->action->code] = [
                'own' => [],
                'rival' => []
            ];
        }

        if ($activity->action->rival_team_action) {
            array_push($this->actions[$activity->action->code]['rival'], $activity);
        } else {
            array_push($this->actions[$activity->action->code]['own'], $activity);
        }
    }
}
