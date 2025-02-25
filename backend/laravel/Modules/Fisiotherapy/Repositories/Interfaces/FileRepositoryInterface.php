<?php

namespace  Modules\Fisiotherapy\Repositories\Interfaces;

interface FileRepositoryInterface {

    public function getTeamFiles($queryParams, $teamId);
}
