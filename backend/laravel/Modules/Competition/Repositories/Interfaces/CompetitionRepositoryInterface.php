<?php

namespace Modules\Competition\Repositories\Interfaces;

interface CompetitionRepositoryInterface
{
    public function findAllByTeamId($team_id, $filter);

    public function findMatchesByTeam($team_id);
}
