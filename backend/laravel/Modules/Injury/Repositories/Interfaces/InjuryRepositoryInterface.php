<?php

namespace  Modules\Injury\Repositories\Interfaces;

interface InjuryRepositoryInterface
{
    public function getInjuriesLocation($entity, $id);

    public function getInjurySituationTypes();

    public function getAffectedSideTypes();

    public function groupInjuryBySeverity($player_id);

    public function groupInjuryByType($player_id);

    public function groupInjuryByLocation($player_id);

    public function totalAbsenceByInjury($player_id);

}
