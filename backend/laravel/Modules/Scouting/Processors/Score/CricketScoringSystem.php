<?php

namespace Modules\Scouting\Processors\Score;

use Modules\Scouting\Processors\Score\ScoreInterface;

class CricketScoringSystem implements ScoreInterface
{
    /**
     * * Maximum amount of outs
     * * until finishing a turn
     * 
     * @constant OUT_LIMIT 
     */
    const OUT_LIMIT = 10;

    /**
     * * Property to keep the track of
     * * the current over on the score
     * 
     * @var $current_over
     */
    protected $current_over;

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
        $this->current_over = 0;
        $this->outs = 0;
        $this->own = 0;
        $this->rival = 0;
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
    public function out()
    {

        if ($this->outs == self::OUT_LIMIT) {
            return $this->changeTurn();
        }

        $this->outs = $this->outs + 1;
    }

    /**
     * * It adds a value to the strikes counter
     * 
     * @return int
     */
    public function changeTurn()
    {
        $this->outs = 0;

        $this->current_over = $this->current_over + 1;

        return 0;
    }

    /**
     * * Current over getter
     * 
     * @return int
     */
    private function getCurrentOver()
    {
        $over = floor($this->current_over / 2) + 1;
        $up_or_down = $this->current_over % 2 == 0 ? 'up' : 'down';

        return sprintf('%s_%s', $over, $up_or_down);
    }

    /**
     * * Getter for the score
     * 
     * @return array
     */
    public function getScore()
    {
        return [
            'current_over' => $this->getCurrentOver(),
            'outs' => $this->outs,
            'own' => $this->own,
            'rival' => $this->rival,
        ];
    }
}
