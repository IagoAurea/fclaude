<?php

namespace  Modules\Injury\Repositories\Interfaces;

interface PlayerInjuryRepositoryInterface
{
    public function groupInjuryBySeverity($player_id);

    public function groupInjuryByType($player_id);

    public function groupInjuryByLocation($player_id);

    public function totalAbsenceByInjury($player_id);

}