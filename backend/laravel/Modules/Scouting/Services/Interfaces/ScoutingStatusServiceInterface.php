<?php

namespace Modules\Scouting\Services\Interfaces;

interface ScoutingStatusServiceInterface
{
    /**
     * Start a scouting for a given competition match
     * 
     * @param int $competition_match_id
     * @return Scouting;
     */
    public function start($competition_match_id);

    /**
     * Pause a scouting for a given competition match
     * 
     * @param int $competition_match_id
     * @param string $in_game_time
     * @return Scouting;
     */
    public function pause($competition_match_id, $request);

    /**
     * Finish a scouting for a given competition match
     * 
     * @param int $competition_match_id
     * @param string $in_game_time
     * @return Scouting;
     */
    public function finish($competition_match_id, $request);
}
