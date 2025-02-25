<?php

namespace Modules\EffortRecovery\Repositories\Interfaces;

interface EffortRecoveryRepositoryInterface {
    public function listPlayers($teamId, $queryParams);

    public function lastEffortRecoveryByPlayer($player_id);

}