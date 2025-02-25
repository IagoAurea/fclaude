<?php

namespace Modules\Scouting\Processors\Score;

use Modules\Scouting\Exceptions\MatchAlreadyHasAWinnerException;
use Modules\Scouting\Processors\Score\ScoreInterface;

class TennisScoringSystem implements ScoreInterface
{
    const OWN_SET_WIN = 'own_sets_won';
    const RIVAL_SET_WIN = 'rival_sets_won';

    const OWN_MATCH_WINNER = 'own';
    const RIVAL_MATCH_WINNER = 'rival';

    const POINT_ZERO = '0';
    const POINT_FIFTEEN = '15';
    const POINT_THIRTY = '30';
    const POINT_FORTY = '40';
    const POINT_AD = 'AD';

    const WINNER = [
        self::OWN_SET_WIN => self::OWN_MATCH_WINNER,
        self::RIVAL_SET_WIN => self::RIVAL_MATCH_WINNER
    ];

    const POINTS_SET = [
        self::POINT_ZERO,
        self::POINT_FIFTEEN,
        self::POINT_THIRTY,
        self::POINT_FORTY,
        self::POINT_AD
    ];

    const POINTS_FOR_AD = 3;

    /**
     * Property to keep the track of
     * the current set index
     * @var $current_set
     */
    protected $current_set;

    /**
     * Property to keep the track of
     * the current game index
     * @var $current_game
     */
    protected $current_game;

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
     * Property to define the amount
     * of playable sets per match
     * @var $set_limit
     */
    protected $set_limit;

    /**
     * Property to define the game limit
     * @var $game_limit
     */
    protected $game_limit;

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
     * Property to keep the system point
     * the own
     * @var $own_points
     */
    protected $own_points;
    
    /**
     * Property to keep the system point
     * the rival
     * @var $rival_points
     */
    protected $rival_points;

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
     * Property to next serve tmp trie break game own or rival
     * @var $next_serve_tmp
     */
    protected $next_serve_tmp;
    
    /**
     * Property to counter player serve
     * @var $count_player_serve
     */
    protected $count_player_serve;

    /**
     * Score constructor.
     */
    public function __construct($scouting)
    {
        $this->own_points = 0;
        $this->rival_points = 0;
        $this->point_limit = 4;
        $this->point_difference_limit = 2;
        $this->set_limit = json_decode($scouting->custom_params, true)['sets'] ?? 5;
        $this->game_limit = 6;
        $this->game_difference_limit = 2;
        $this->game_tiebreak_limit = 7;
        $this->current_set = 0;
        $this->own = array_fill(0, $this->set_limit, 0);
        $this->rival = array_fill(0, $this->set_limit, 0);
        $this->own_sets_won = 0;
        $this->rival_sets_won = 0;
        $this->winner = null;
        $this->start_game = $scouting->start_match == 'L' ? 'own':'rival';
        $this->next_serve = null;
        $this->next_serve_tmp = null;
        $this->count_player_serve = 0;
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
        if ($amount == self::POINT_ZERO) {
            return;
        }

        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->own_points = $this->own_points + ($amount * $factor);

        if ($this->own[$this->current_set] == $this->game_limit && $this->rival[$this->current_set] == $this->game_limit) {
            $this->changeNextServe();
        }

        if ($this->own_points >= $this->point_limit) {
            if (abs($this->own_points - $this->rival_points) >= $this->point_difference_limit) {
                $this->addGameToOwn(1);
            }
        }

        return $this->own;
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
    public function addGameToOwn($amount, $factor = 1)
    {
        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->own_points = 0;
        $this->rival_points = 0;

        $this->own[$this->current_set] = $this->own[$this->current_set] + ($amount * $factor);

        if ($this->own[$this->current_set] >= $this->game_tiebreak_limit) {
            $this->changeCurrentSet(self::OWN_SET_WIN);
        }

        if ($this->own[$this->current_set] >= $this->game_limit) {
            if (abs($this->own[$this->current_set] - $this->rival[$this->current_set]) >= $this->game_difference_limit) {
                $this->changeCurrentSet(self::OWN_SET_WIN);
            }
        }

        $this->changeNextServe();

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
        if ($amount == self::POINT_ZERO) {
            return;
        }

        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->rival_points = $this->rival_points + ($amount * $factor);

        if ($this->own[$this->current_set] == $this->game_limit && $this->rival[$this->current_set] == $this->game_limit) {
            $this->changeNextServe();
        }

        if ($this->rival_points >= $this->point_limit) {
            if (abs($this->own_points - $this->rival_points) >= $this->point_difference_limit) {
                $this->addGameToRival(1);
            }
        }

        return $this->rival;
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
    public function addGameToRival($amount, $factor = 1)
    {
        if ($this->winner) {
            throw new MatchAlreadyHasAWinnerException;
        }

        $this->rival_points = 0;
        $this->own_points = 0;

        $this->rival[$this->current_set] = $this->rival[$this->current_set] + ($amount * $factor);
     
        if ($this->rival[$this->current_set] >= $this->game_tiebreak_limit) {
            $this->changeCurrentSet(self::RIVAL_SET_WIN);
        }

        if ($this->rival[$this->current_set] >= $this->game_limit) {
            if (abs($this->own[$this->current_set] - $this->rival[$this->current_set]) >= $this->point_difference_limit) {
                $this->changeCurrentSet(self::RIVAL_SET_WIN);
            }
        }

        $this->changeNextServe();

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
            'winner' => $this->winner,
            'current_set' => $this->current_set,
            'own_points' => $this->own_points,
            'rival_points' => $this->rival_points,
            'point_set_own' => $this->pointSet($this->own_points),
            'point_set_rival' => $this->pointSet($this->rival_points),
            'start_game' => $this->start_game,
            'next_serve' => $this->next_serve,
            'set_limit' => $this->set_limit
        ];
    }

    /**
     * Determinate if the current
     * set is the last one
     *
     * @return bool
     */
    private function isLastSet()
    {
        return $this->current_set == ($this->set_limit);
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

        if ($this->isLastSet() || $this->verifyLastSets()) {
            $this->winnerSet($set_winner);
        }
    }

    /**
     * Check if the last two sets were won by the same
     */
    private function verifyLastSets()
    {
        if($this->current_set < ($this->set_limit - 1)) { return false; }

        return $this->compareSetPreviousWithOwnOrRival();
    }

    /**
     * Compare set previous with own or rival
     */
    private function compareSetPreviousWithOwnOrRival()
    {
        if ($isWinnerOwn = $this->compareSetPrevious($this->own)) {
            return $isWinnerOwn;
        }

        if ($isWinnerRival = $this->compareSetPrevious($this->rival)) {
            return $isWinnerRival;
        }

        return false;
    }

    /**
     * Compare value actual set with previous set
     */
    public function compareSetPrevious($sets)
    {
        $quantity_sets = count($sets) - 1;

        for($i = 0; $i < $quantity_sets; $i++) {
            if ($sets[$i] > self::POINT_ZERO && $sets[$i] == $sets[$i + 1]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set winner
     */
    private function winnerSet($set_winner)
    {
        $this->winner = self::WINNER[$set_winner];

        $this->own_points = 0;

        $this->rival_points = 0;

        $this->current_set = (int) $this->current_set - 1;

        $this->getScore();
    }

    /**
     * Transform point a point set
     */
    private function pointSet($points_set)
    {
        if($this->own[$this->current_set] == $this->game_limit && $this->rival[$this->current_set] == $this->game_limit) {
            return $points_set;
        }

        if ($this->own_points > self::POINTS_FOR_AD && $this->rival_points > self::POINTS_FOR_AD) {
            if($this->own_points == $this->rival_points) {
                return self::POINT_FORTY;
            }

            if(($this->own_points > $this->rival_points && $this->own_points == $points_set) ||
                ($this->rival_points > $this->own_points && $this->rival_points == $points_set)) {
                return self::POINT_AD;
            }

            return self::POINT_FORTY;
        }

        return $points_set < count(self::POINTS_SET) ? self::POINTS_SET[$points_set] : self::POINT_AD;
    }

    /**
     * Change next serve between own and rival
     */
    private function changeNextServe()
    {
        if ($this->own[$this->current_set] >= $this->game_limit && $this->rival[$this->current_set] >= $this->game_limit) {
            if (!$this->next_serve_tmp) {
                $this->next_serve_tmp = $this->next_serve;
                $this->nextServe();
            }

            $this->nextServe(true);

            return;
        }
 
        if($this->next_serve_tmp) {
            $this->next_serve = $this->next_serve_tmp;
            
            $this->next_serve_tmp = null;

            $this->count_player_serve = 0;
        }

        $this->nextServe();
    }

    /**
     * Update next serve
     */
    private function nextServe($isTieBreak = false)
    {
        if($isTieBreak) {
            if($this->count_player_serve < 1) {
                $this->count_player_serve ++;

                return;
            }

            $this->count_player_serve = 0;
        }

        $this->next_serve = $this->next_serve == 'own' || is_null($this->next_serve) && $this->start_game == 'own' ?
            'rival' :
            'own';
    }
}
