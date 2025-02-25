<?php

namespace Modules\Club\Http\Controllers;

use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;
use Modules\Club\Http\Requests\AcademicYearStoreRequest;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;
use Illuminate\Http\Response;

class AcademicYearController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $academicYearRepository;

    /**
     * Instances a new controller class
     */
    public function __construct(AcademicYearRepositoryInterface $academicYearRepository)
    {
        $this->academicYearRepository = $academicYearRepository;
    }

    /**
     * Stores a new academic year
     *
     * @return Response
     */
    public function store($club_id, AcademicYearStoreRequest $request)
    {
        $payload = [
            'club_id' => $club_id,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => boolval($request->is_active),
        ];

        $activePeriodSearch = [
            'club_id' => $club_id,
            'is_active' => true
        ];

        $activePeriod = $this->academicYearRepository->findOneBy($activePeriodSearch);
        if ($activePeriod) {
            $activePeriod->update(['is_active' => false]);
        }

        $response = $this->academicYearRepository->create($payload);

        return $this->sendResponse($response, $this->translator('academic_year_created'));
    }
}
