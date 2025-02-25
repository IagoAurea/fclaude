<?php

namespace Modules\Scouting\Processors\Score;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Score\ScoreInterface;

class BadmintonScoringSystem implements ScoreInterface
{
    const OWN_SET_WIN = 'own_sets_won';
    const RIVAL_SET_WIN = 'rival_sets_won';
    
    const OWN_MATCH_WINNER = 'own';
    const RIVAL_MATCH_WINNER = 'rival';

    const WINNER = [
        self::OWN_SET_WIN => self::OWN_MATCH_WINNER,
        self::RIVAL_SET_WIN => self::RIVAL_MATCH_WINNER
    ];

    /**
     * Property to keep the track of
     * the current set index
     * @var $current_set
     */
    protected $current_set;

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
     * Property to keep the track of
     * the score for the own team points
     * @var $own
     */
    protected $own_points;

    /**
     * Property to keep the track of
     * the score for the rival team points
     * @var $rival
     */
    protected $rival_points;

    /**
     * Property to define the amount
     * of playable sets per match
     * @var $set_limit
     */
    protected $set_limit;

    /**
     * Property to define the amount
     * of playable points per set
     * (it could extend if the)
     * difference between points
     * is smaller than the
     * point difference limit
     * @var $point_limit
     */
    protected $point_limit;

    /**
     * Property to define the point limit
     * until a set will be played when
     * to break a tie after the regular
     * point limit is reached
     * @var $tiebreak_point_limit
     */
    protected $tiebreak_point_limit;

    /**
     * Property to define the max
     * point difference between
     * two teams after the point
     * limit is reached in order
     * to determinate who is the
     * set winner
     * @var $point_difference_limit
     */
    protected $point_difference_limit;

    /**
     * Property to keep the track of
     * the sets won by the own team
     * @var $own_sets_won
     */
    protected $own_sets_won;

    /**
     * Property to keep the track of
     * the sets won by the rival team
     * @var $rival_sets_won
     */
    protected $rival_sets_won;

    /**
     * Property to keep the track of
     * the match winner
     * @var $rival_sets_won
     */
    protected $winner;

    /**
     * Property to start game own or rival
     * @var $start_game
     */
    protected $start_game;

    /**
     * Property to next serve game own or rival
     * @var $next_serve
     */
    protected $next_serve;

    /**
     * Score constructor.
     */
    public function __construct($scouting)
    {
        $this->own_points = 0;
        $this->rival_points = 0;
        $this->current_set = 0;
        $this->set_limit = 3;
        $this->own = array_fill(0, $this->set_limit, 0);
        $this->rival = array_fill(0, $this->set_limit, 0);
        $this->point_limit = 21;
        $this->tiebreak_point_limit = 30;
        $this->point_difference_limit = 2;
        $this->own_sets_won = 0;
        $this->rival_sets_won = 0;
        $this->winner = null;
        $this->start_game = $scouting->start_match == 'L' ? 'own':'rival';
        $this->next_serve = null;
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
        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->own[$this->current_set] = $this->own[$this->current_set] + ($amount * $factor);

        $this->own_points = $this->own_points + ($amount * $factor);

        $this->next_serve = self::OWN_MATCH_WINNER;

        if ($this->own[$this->current_set] == $this->tiebreak_point_limit) {
            $this->changeCurrentSet(self::OWN_SET_WIN);

            return $this->own;
        }

        if ($this->own[$this->current_set] >= $this->point_limit) {
            if (abs($this->own[$this->current_set] - $this->rival[$this->current_set]) >= $this->point_difference_limit) {
             $this->changeCurrentSet(self::OWN_SET_WIN);
            }
        }

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
        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->rival[$this->current_set] = $this->rival[$this->current_set] + ($amount * $factor);

        $this->rival_points = $this->rival_points + ($amount * $factor);

        $this->next_serve = self::RIVAL_MATCH_WINNER;

        if ($this->own[$this->current_set] == $this->tiebreak_point_limit) {
            $this->changeCurrentSet(self::RIVAL_SET_WIN);

            return $this->rival;
        }

        if ($this->rival[$this->current_set] >= $this->point_limit) {
            if (abs($this->own[$this->current_set] - $this->rival[$this->current_set]) >= $this->point_difference_limit) {
             $this->changeCurrentSet(self::RIVAL_SET_WIN);
            }
        }

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
            'rival' => $this->rival,
            'own_sets_won' => $this->own_sets_won,
            'rival_sets_won' => $this->rival_sets_won,
            'current_set' => $this->current_set,
            'winner' => $this->winner,
            'own_points' => $this->own_points,
            'rival_points' => $this->rival_points,
            'start_game' => $this->start_game,
            'next_serve' => $this->next_serve
        ];
    }

    /**
     * Return the minimum amount of sets
     * needed to win a match
     *
     * @return array
     */
    private function minimumWinningSets()
    {
        return ceil($this->set_limit / 2);
    }

    /**
     * Change the current set
     *
     * @return array
     */
    private function changeCurrentSet($set_winner)
    {
        $this->current_set = $this->current_set + 1;

        $this->{$set_winner} = $this->{$set_winner} + 1;

        $this->own_points = 0;

        $this->rival_points = 0;

        if ($this->{$set_winner} == $this->minimumWinningSets()) {
            $this->winner = self::WINNER[$set_winner];
        }
    }

}
