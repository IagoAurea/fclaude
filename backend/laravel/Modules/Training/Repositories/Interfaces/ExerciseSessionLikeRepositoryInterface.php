<?php

namespace  Modules\Training\Repositories\Interfaces;

interface ExerciseSessionLikeRepositoryInterface
{
   public function findAllByTeamId($team_id);
   
   public function findAllBySessionCode($exercise_session_code);
   
}