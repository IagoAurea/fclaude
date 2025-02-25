<?php

namespace Modules\Scouting\Processors\Score;

interface ScoreInterface
{
    /**
     * It adds a value to the own team score
     * by multiplying the amount with a
     * factor which defaults to 1
     * 
     * @param int $amount
     * @param int $factor
     * @return int
     */
    public function addToOwn($amount, $factor = 1);

    /**
     * It adds a value to the rival team score
     * by multiplying the amount with a
     * factor which defaults to 1
     * 
     * @param int $amount
     * @param int $factor
     * @return int
     */
    public function addToRival($amount, $factor = 1);

    /**
     * Getter for the score
     * 
     * @return array
     */
    public function getScore();
}
