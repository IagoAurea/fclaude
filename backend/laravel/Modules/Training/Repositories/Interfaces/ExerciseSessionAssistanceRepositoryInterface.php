<?php

namespace  Modules\Training\Repositories\Interfaces;

interface ExerciseSessionAssistanceRepositoryInterface
{
    public function findAllTraining($entity, $id, $start, $end);

    public function createAssistanceToExerciseSession($request);
}