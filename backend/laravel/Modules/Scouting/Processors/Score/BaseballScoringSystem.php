<?php

namespace Modules\Scouting\Processors\Score;

use Modules\Scouting\Processors\Score\ScoreInterface;

class BaseballScoringSystem implements ScoreInterface
{
    /**
     * * Maximum amount of outs
     * * until finishing a turn
     *
     * @constant OUT_LIMIT
     */
    const OUT_LIMIT = 2;

    /**
     * * Maximum amount of strikes until out
     *
     * @constant STRIKE_LIMIT
     */
    const STRIKE_LIMIT = 2;

    /**
     * * Maximum amount of balls until a walk;
     *
     * @constant BALL_LIMIT
     */
    const BALL_LIMIT = 3;

    /**
     * * Property to keep the track of
     * * the current inning on the score
     *
     * @var $current_inning
     */
    protected $current_inning;

    /**
     * * Property to keep the track of
     * * the strikes on the score
     *
     * @var $strikes
     */
    protected $strikes;

    /**
     * * Property to keep the track of
     * * the balls on the score
     *
     * @var $balls
     */
    protected $balls;

    /**
     * * Property to keep the track of
     * * the score for the own team
     * @var $own
     */
    protected $own;

    /**
     * * Property to keep the track of
     * * the score for the rival team
     *
     * @var $rival
     */
    protected $rival;

    /**
     * * Score constructor.
     */
    public function __construct()
    {
        $this->current_inning = 0;
        $this->strikes = 0;
        $this->balls = 0;
        $this->outs = 0;
        $this->own = 0;
        $this->rival = 0;
        $this->own_errors = 0;
        $this->rival_errors = 0;
    }

    /**
     * * It adds a value to the own team score
     * * by multiplying the amount with a
     * * factor which defaults to 1
     * 
     * @param int $amount
     * @param int $factor
     * @return int
     */
    public function addToOwn($amount, $factor = 1)
    {
        $this->own = $this->own + ($amount * $factor);

        return $this->own;
    }

    /**
     * * It adds a value to the rival team score
     * * by multiplying the amount with a
     * * factor which defaults to 1
     * 
     * @param int $amount
     * @param int $factor
     * @return int
     */
    public function addToRival($amount, $factor = 1)
    {
        $this->rival = $this->rival + ($amount * $factor);

        return $this->rival;
    }

    /**
     * * It adds a value to the strikes counter
     * 
     * @return int
     */
    public function strike()
    {
        if ($this->strikes == self::STRIKE_LIMIT) {
            return $this->out();
        }

        $this->strikes = $this->strikes + 1;

        return $this->strikes;
    }

    /**
     * * It adds a value to the balls counter
     * 
     * @return int
     */
    public function ball()
    {
        if ($this->balls == self::BALL_LIMIT) {
            $this->balls = 0;
            $this->strikes = 0;

            return true;
        }

        $this->balls = $this->balls + 1;

        return false;
    }
    
    /**
     * * It adds a value to the balls counter
     * 
     * @return int
     */
    public function walk()
    {
        $this->balls = 0;
        $this->strikes = 0;
    }

    /**
     * * It adds a value to the strikes counter
     * 
     * @return int
     */
    public function out()
    {
        $this->strikes = 0;
        $this->balls = 0;

        if ($this->outs == self::OUT_LIMIT) {
            return $this->changeTurn();
        }

        $this->outs = $this->outs + 1;
    }

    /**
     * * It adds a value to the own_errors counter
     * 
     * @return int
     */
    public function own_error()
    {
        $this->own_errors = $this->own_errors + 1;
    }

    /**
     * * It adds a value to the rival_errors counter
     * 
     * @return int
     */
    public function rival_error()
    {
        $this->rival_errors = $this->rival_errors + 1;
    }

    /**
     * * It adds a value to the strikes counter
     * 
     * @return int
     */
    public function changeTurn()
    {
        $this->outs = 0;

        $this->current_inning = $this->current_inning + 1;

        return 0;
    }

    /**
     * * Current inning getter
     * 
     * @return int
     */
    private function getCurrentInning()
    {
        $inning = floor($this->current_inning / 2) + 1;
        $up_or_down = $this->current_inning % 2 == 0 ? 'up' : 'down';

        return sprintf('%s_%s', $inning, $up_or_down);
    }

    /**
     * * Getter for the score
     * 
     * @return array
     */
    public function getScore()
    {
        return [
            'current_inning' => $this->getCurrentInning(),
            'outs' => $this->outs,
            'strikes' => $this->strikes,
            'balls' => $this->balls,
            'own' => $this->own,
            'rival' => $this->rival,
            'own_errors' => $this->own_errors,
            'rival_errors' => $this->rival_errors
        ];
    }
}
