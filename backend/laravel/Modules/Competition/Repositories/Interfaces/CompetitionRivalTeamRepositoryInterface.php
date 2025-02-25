<?php

namespace Modules\Competition\Repositories\Interfaces;

interface CompetitionRivalTeamRepositoryInterface
{
    public function findAllByCompetitionId($competition_id);
}
