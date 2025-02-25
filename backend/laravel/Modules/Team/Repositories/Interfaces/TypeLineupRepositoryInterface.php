<?php

namespace  Modules\Team\Repositories\Interfaces;

interface TypeLineupRepositoryInterface
{
    public function findAllBySportAndModality($sport_code, $modality_code);
}
