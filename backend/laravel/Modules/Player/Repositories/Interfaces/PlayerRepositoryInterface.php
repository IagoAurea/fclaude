<?php

namespace  Modules\Player\Repositories\Interfaces;

interface PlayerRepositoryInterface
{
    public function findPlayersByTeamAndExclude($search, $exclude, $relations);

	public function allPlayersTestByTeam($team_id);
	
	public function getLateritiesTypes();

	public function getPlayersWithPsychologyDataByTeam($filters,$team_id);

	public function getPlayersWithFisiotherapyData($teamId);
}
