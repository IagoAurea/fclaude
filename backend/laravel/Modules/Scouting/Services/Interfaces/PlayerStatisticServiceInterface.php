<?php

namespace Modules\Scouting\Services\Interfaces;

interface PlayerStatisticServiceInterface
{
    public function byCompetition($competition_id, $player_id);
}
