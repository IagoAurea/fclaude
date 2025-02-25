<?php

namespace Modules\Generality\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Repositories\Interfaces\WeekDayRepositoryInterface;

class WeekDayController extends BaseController
{
    /**
     * @var $weekDayRepository
     */
    protected $weekDayRepository;

    /**
     * Create a new controller instance
     */
    public function __construct(WeekDayRepositoryInterface $weekDayRepository)
    {
        $this->weekDayRepository = $weekDayRepository;
    }

    /**
     * Display a listing the kinship.
     * @return Response
     */
    public function index()
    {
        $weekdays = $this->weekDayRepository->findAllTranslated();

        return $this->sendResponse($weekdays, 'Week Day List');
    }
}
