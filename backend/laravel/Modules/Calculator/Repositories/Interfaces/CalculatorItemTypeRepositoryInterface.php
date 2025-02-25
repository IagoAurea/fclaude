<?php

namespace Modules\Calculator\Repositories\Interfaces;

interface CalculatorItemTypeRepositoryInterface 
{
    public function getItemType(Float $point);
}