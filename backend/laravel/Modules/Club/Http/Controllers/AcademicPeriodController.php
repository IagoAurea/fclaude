<?php

namespace Modules\Club\Http\Controllers;

use Modules\Club\Repositories\Interfaces\AcademicPeriodRepositoryInterface;
use Modules\Club\Http\Requests\AcademicPeriodStoreRequest;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Response;

class AcademicPeriodController extends BaseController
{
    /**
     * @var object
     */
    protected $academicPeriodRepository;

    /**
     * Instances a new controller class
     */
    public function __construct(AcademicPeriodRepositoryInterface $academicPeriodRepository)
    {
        $this->academicPeriodRepository = $academicPeriodRepository;
    }

    /**
     * Stores a new academic period
     * 
     * @return Response
     */
    public function index($academic_year_id)
    {
        $response = $this->academicPeriodRepository->findBy(['academic_year_id' => $academic_year_id]);

        return $this->sendResponse($response, sprintf('Academic periods by academic year %s', $academic_year_id));
    }

    /**
     * Stores a new academic period
     * 
     * @return Response
     */
    public function store($academic_year_id, AcademicPeriodStoreRequest $request)
    {
        $payload = [
            'academic_year_id' => $academic_year_id,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $response = $this->academicPeriodRepository->create($payload);

        return $this->sendResponse($response, sprintf('Academic period created for academic year %s', $academic_year_id));
    }
}
