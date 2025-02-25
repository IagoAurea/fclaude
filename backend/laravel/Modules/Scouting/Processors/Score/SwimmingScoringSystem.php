<?php

namespace Modules\Scouting\Processors\Score;

class SwimmingScoringSystem implements ScoreInterface
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

    public function __construct($scouting)
    {
        $this->own = collect([]);
        $this->rival = collect([]);
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
        $this->own->push($amount * $factor);

        return $this;
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
        $this->rival->push($amount * $factor);

        return $this;
    }

    /**
     * Getter for the score
     * 
     * @return array
     */
    public function getScore()
    {
        return [
            'position' => $this->own->last(),
            'own' => $this->own
        ];
    }
}
