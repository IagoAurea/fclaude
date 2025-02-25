<?php

namespace  Modules\Training\Repositories\Interfaces;

interface ExerciseSessionRepositoryInterface
{
	public function updateExerciseSession($request, $code);

	public function createExerciseSession($request);

	public function findExerciseSessionById($id);

	public function findAllExerciseSessionsByUserAndEntity($user_id, $entity, $entityId);

	public function listOfMaterialsBySession($session_id);

	public function searchExerciseSessions($requestData, $entityId);

	public function findAllAssistancesBySession($code, $academic_year_id);
}