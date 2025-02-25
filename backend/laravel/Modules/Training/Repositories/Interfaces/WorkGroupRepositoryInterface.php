<?php

namespace  Modules\Training\Repositories\Interfaces;

interface WorkGroupRepositoryInterface
{
    public function findAllWorkGroupsByExerciseSession($exercise_session_id);

    public function findWorkGroupByCode($code);

    public function findWorkGroupByExercise($session_exercise_code);
}