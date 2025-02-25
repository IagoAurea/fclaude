<?php

namespace Modules\EffortRecovery\Repositories\Interfaces;

interface WellnessQuestionnaireAnswerItemRepositoryInterface
{
	public function findAllTranslated();

	public function findByTypeTranslated($typeId);
}