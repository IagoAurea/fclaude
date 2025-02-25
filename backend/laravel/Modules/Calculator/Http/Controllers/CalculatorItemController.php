<?php

namespace Modules\Calculator\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\Calculator\Services\CalculatorItemService;
use Exception;


class CalculatorItemController extends BaseController
{
    /**
     * @var $calculatorItemService
     */
    protected $calculatorItemService;

    /**
     * Creates a new controller instance
     */
    public function __construct(CalculatorItemService $calculatorItemService)
    {
        $this->calculatorItemService = $calculatorItemService;
    }
}
