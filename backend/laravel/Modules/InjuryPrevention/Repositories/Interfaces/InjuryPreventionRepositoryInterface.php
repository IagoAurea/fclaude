<?php

namespace Modules\InjuryPrevention\Repositories\Interfaces;

interface InjuryPreventionRepositoryInterface 
{
    public function listPlayers($requestData, $teamId);

    public function deleteWeekDays($injuryId);
}