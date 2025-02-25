<?php

namespace  Modules\Training\Repositories\Interfaces;

interface ExerciseSessionDetailRepositoryInterface
{
    public function findAllBySessionCode($session_code);
    
    public function findAllByTeamId($team_id);
}