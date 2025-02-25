<?php

namespace Modules\Club\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\Club\Services\SchoolCenterTypeService;

class SchoolCenterTypeController extends BaseController
{

    /**
     * @var object
     */
    protected $schoolTypeService;

    /**
     * Instances a new controller class
     */
    public function __construct(SchoolCenterTypeService $schoolTypeService) {
        $this->schoolTypeService = $schoolTypeService;
    }

    /**
     * Display all the clubs related to the user doing the request.
     * 
     * @return Response
     */
    public function index()
    {
        $types = $this->schoolTypeService->list();
        return $this->sendResponse($types, 'School Center Types List');
    }
}
