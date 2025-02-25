<?php

namespace  Modules\Injury\Repositories\Interfaces;

interface InjuryTypeSpecRepositoryInterface
{
	public function findAllTranslated($injuryTypeId);
}