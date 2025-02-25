<?php

namespace  Modules\Generality\Repositories\Interfaces;

interface RefereeRepositoryInterface
{
    public function findAllBySport($sport_code);
}
