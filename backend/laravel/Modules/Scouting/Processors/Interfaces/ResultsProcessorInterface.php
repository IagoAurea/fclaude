<?php

namespace Modules\Scouting\Processors\Interfaces;

interface ResultsProcessorInterface
{
    /**
     * It process the scouting activities associated
     * to the given competition match and returns
     * the results of the scouting as an array
     * 
     * @param string $competition_match_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function match($competition_match_id);

    /**
     * It returns the scouting activities associated
     * to the given competition match and a
     * specific player
     * 
     * @param string $competition_match_id
     * @param string $player_id
     * @throws \Modules\Scouting\Exceptions\CompetitionMatchNotFoundException
     * @return array
     */
    public function playerMatchActions($competition_match_id, $player_id);

}
