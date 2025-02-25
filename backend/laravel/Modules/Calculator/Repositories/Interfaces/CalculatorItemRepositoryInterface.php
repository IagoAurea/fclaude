<?php

namespace Modules\Calculator\Repositories\Interfaces;

interface CalculatorItemRepositoryInterface
{
	public function findAllTranslated();

	public function findItems($type);
}