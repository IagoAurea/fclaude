<?php

namespace  Modules\Scouting\Repositories\Interfaces;

interface ScoutingActivityRepositoryInterface
{
    /**
     * Returns the scouting activities
     * associated to a given scouting
     * 
     * @param int $scouting_id
     */
    public function getMatchActivities($scouting_id);

    /**
     * Returns the scouting activities
     * associated to a given scouting
     * for a specific player
     * 
     * @param int $scouting_id
     * @param int $player_id
     */
    public function getPlayerMatchActivities($scouting_id, $player_id);

    /**
     * Returns the scouting activities
     * associated to a given scouting
     * for a specific player
     * 
     * @param int $scouting_id
     */
    public function getMatchActivitiesGroupedByPlayers($scouting_id);

    /**
     * Returns the latest scouting
     * for a specific player
     * 
     * @param int $player_id
     */
    public function latestPlayerScouting($player_id);
}
