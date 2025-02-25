<?php

namespace  Modules\Team\Repositories\Interfaces;

interface WorkingExperienceStaffRepositoryInterface
{
	public function findAllByStaffId($staff_id);
	
	public function findExperienceById($working_experience_id);

	public function createWorkingExperiences($request);
}