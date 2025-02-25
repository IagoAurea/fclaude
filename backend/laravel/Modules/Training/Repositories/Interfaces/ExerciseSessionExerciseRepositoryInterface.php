<?php

namespace  Modules\Training\Repositories\Interfaces;

interface ExerciseSessionExerciseRepositoryInterface
{
    public function createExerciseSessionExercise($request);

    public function findExerciseSessionExerciseByCode($code);

    public function searchExercises($exercise_session_code,$search,$order);
}