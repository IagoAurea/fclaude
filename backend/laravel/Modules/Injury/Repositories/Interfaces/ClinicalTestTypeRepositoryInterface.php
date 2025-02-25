<?php

namespace  Modules\Injury\Repositories\Interfaces;

interface ClinicalTestTypeRepositoryInterface
{
	public function findAllTranslated();

	public function getRegisteredIds();
}
