<?php

namespace Modules\Player\Http\Controllers;

use Modules\Player\Repositories\Interfaces\ClubArrivalTypeRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;

class ClubArrivalTypeController extends BaseController
{
    /**
     * @var $clubArrivalTypeRepository
     */
    protected $clubArrivalTypeRepository;


    public function __construct(ClubArrivalTypeRepositoryInterface $clubArrivalTypeRepository)
    {
        $this->clubArrivalTypeRepository = $clubArrivalTypeRepository;
    }

    /**
     * Display a listing of diseases.
     * @return Response
     */
    public function index()
    {
        $clinical_tests = $this->clubArrivalTypeRepository->findAllTranslated();
        return $this->sendResponse($clinical_tests, 'List Clinical Tests');
    }
}
