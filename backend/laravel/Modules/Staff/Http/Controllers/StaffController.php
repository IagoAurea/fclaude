<?php

namespace Modules\Staff\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\Staff\Services\StaffService;

class StaffController extends BaseController
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $staffService;

    /**
     * Creates a new controller instance.
     */
    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * 
     */
    public function index()
    {

    }

    /**
     * 
     */
    public function store(Request $request)
    {
        try {
            return $request->all();
        } catch (Exception $exception) {
            return $this->sendError('Error by storing staff user', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
