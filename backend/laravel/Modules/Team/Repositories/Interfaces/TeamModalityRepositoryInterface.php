<?php

namespace  Modules\Team\Repositories\Interfaces;

interface TeamModalityRepositoryInterface
{
	public function findAllTranslated();

	public function findBySportAndTranslated($sport);
}