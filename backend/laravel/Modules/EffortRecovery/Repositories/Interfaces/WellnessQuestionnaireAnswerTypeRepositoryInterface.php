<?php

namespace Modules\EffortRecovery\Repositories\Interfaces;

interface WellnessQuestionnaireAnswerTypeRepositoryInterface
{
	public function findAllTranslated();

	public function findAllRelated();
}