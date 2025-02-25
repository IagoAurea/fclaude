<?php

namespace Modules\Club\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Club\Http\Requests\StoreWorkingExperiencesRequest;
use Modules\Club\Http\Requests\UpdateWorkingExperiencesRequest;
use Modules\Club\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;

class WorkingExperiencesController extends Controller
{
    /**
     * @var $workingExperiencesRepository
     */
    protected $workingExperiencesRepository;

    public function __construct(
        WorkingExperiencesRepositoryInterface $workingExperiencesRepository
    ) {
        $this->workingExperiencesRepository = $workingExperiencesRepository;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return Response
     */
    public function store(StoreWorkingExperiencesRequest $request)
    {
        try {
            $workingExperiences = $this->workingExperiencesRepository->create($request);
            return $this->sendResponse($workingExperiences, 'Working Experiences stored', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError('Error by storing Working Experiences', $exception->getMessage());
        }
    }


    /**
     * Update the working Experiences data sent on storage.
     * 
     * @param Request $request
     * @param Int $id
     * @return Response
     */
    public function update(UpdateWorkingExperiencesRequest $request, $id)
    {
        try {
            $workingExperiences = $this
                ->workingExperiencesRepository->getWorkingExperiencesById($id,$request->staff_id);
            $this->workingExperiencesRepository->update($workingExperiencesData, $workingExperiences);
            return $this->sendResponse($staff, 'Working Experiences data updated');
        } catch (\Exception $exception) {
            return $this->sendError('Error by updating Working Experiences', $exception->getMessage());
        }
    }

    /**
     * Makes a logical working Experiences deletion from database.
     * 
     * @param Int $id
     * @return Response
     */
    public function destroy(UpdateWorkingExperiencesRequest $request, $id)
    {
        try {
            $workingExperiences = $this->workingExperiencesRepository->getWorkingExperiencesById($request->staff_id,$id);
            $workingExperiences->delete();
            return $this->sendResponse(NULL, 'Working Experiences deleted', Response::HTTP_ACCEPTED);
        } catch (\Exception $exception) {
            return $this->sendError('Error by deleting Working Experiences', $exception->getMessage());
        }
    }
}
