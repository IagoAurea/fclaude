<?php

namespace Modules\Scouting\Processors\Score;

use Modules\Scouting\Processors\Score\ScoreInterface;

class WaterpoloScoringSystem implements ScoreInterface
{
    /**
     * Property to keep the track of
     * the score for the own team
     * @var $own
     */
    protected $own;

    /**
     * Property to keep the track of
     * the score for the rival team
     * @var $rival
     */
    protected $rival;

    /**
     * Score constructor.
     */
    public function __construct()
    {
        $this->own = 0;
        $this->rival = 0;
    }

    /**
     * It adds a value to the own team score
     * by multiplying the amount with a
     * factor which defaults to 1
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
     * It adds a value to the rival team score
     * by multiplying the amount with a
     * factor which defaults to 1
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
     * Getter for the score
     * 
     * @return array
     */
    public function getScore()
    {
        return [
            'own' => $this->own,
            'rival' => $this->rival
        ];
    }
}
