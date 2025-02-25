<?php

namespace  Modules\Scouting\Repositories\Interfaces;

interface ScoutingRepositoryInterface
{
    /**
     * Get next matches by team
     * 
     * @param int $team_id
     * @param array $filters
     * @return mixed
     */
	public function findAllNextMatchesToScoutByTeam($team_id, $filters = []);

    /**
     * Finds a scout by a given competition match
     * or create it if not found
     * 
     * @param int $competition_match_id
     * @param int $scouting_id
     * @throws CompetitionMatchNotProvidedException
     * @throws CompetitionMatchNotFoundException
     * @return mixed
     */
	public function findOrCreateScout($competition_match_id, $scouting_id = null);

    /**
     * Change status of a scouting to
     * STARTED, PASUED, or FINISHED
     * 
     * @param int $scouting
     * @param int $status
     * @throws ScoutingNotFoundException
     * @throws ScoutingStatusForbiddenException
     * @throws ScoutingStatusUpdateException
     * @return mixed
     */
	public function changeStatus($scouting, $status, $request);

    /**
     * Returns the sport of the scouting
     * 
     * @param int $scouting
     * @throws ScoutingNotFoundException
     * @return mixed
     */
	public function getSport($scouting);
}