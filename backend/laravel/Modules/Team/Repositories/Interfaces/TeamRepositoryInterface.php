<?php

namespace  Modules\Team\Repositories\Interfaces;

interface TeamRepositoryInterface
{
    public function getAllTeamsWithPlayersByUser($user_id);

	public function getGenderTypes();

    public function findAllByOwner($userId, $request, $clubId = null, $teamsId = []);

    public function countMembers($team_id);

    public function findAllPlayersByTeam($team_id);

    public function findTeamById($team_id);

    public function listTeamRDFInjuries($team);
}