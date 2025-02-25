<?php

namespace Modules\Qualification\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Rest\BaseController;
use Modules\Qualification\Http\Requests\QualificationStoreRequest;
use Modules\Qualification\Http\Requests\QualificationUpdateRequest;
use Modules\Qualification\Services\Interfaces\QualificationServiceInterface;

class QualificationController extends BaseController
{
    /**
     * Service
     *
     * @var $qualificationService
     */
    protected $qualificationService;

    /**
     * Instances a new controller class
     *
     * @param $qualificationService
     */
    public function __construct(QualificationServiceInterface $qualificationService)
    {
        $this->qualificationService = $qualificationService;
    }

    /**
     * Display a list of qualifications
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/school-section/{classroom_academic_year_id}",
     *      tags={"Qualification"},
     *      summary="List of qualifications of an academic year of a given classroom",
     *      operationId="qualification-index",
     *      description="Display a list of qualifications",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function index($classroom_academic_year_id)
    {
        $response = $this->qualificationService->getListOfQualifications($classroom_academic_year_id);

        return $this->sendResponse($response, sprintf('List of qualifications by the classroom academic year %s', $classroom_academic_year_id));
    }

    /**
     * Display a given qualification
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/{qualification_id}",
     *      tags={"Qualification"},
     *      summary="Display a given qualification",
     *      operationId="qualification-show",
     *      description="Display a given qualification",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/qualification_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function show($qualification_id)
    {
        $response = $this->qualificationService->getQualification($qualification_id);

        return $this->sendResponse($response, sprintf('Get qualification by the id: %s', $qualification_id));
    }

    /**
     * Store a new qualification for a given classroom
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/qualification",
     *      tags={"Qualification"},
     *      summary="Store a new qualification for a given classroom",
     *      operationId="store-qualification",
     *      description="Store a new qualification for a given classroom",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          ref="#/components/schemas/QualificationStoreRequest"
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function store(QualificationStoreRequest $request)
    {
        $response = $this->qualificationService->store($request);

        return $this->sendResponse($response, 'The qualification has been added');
    }

    /**
     * Update a given qualification
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/qualification/{qualification_id}",
     *      tags={"Qualification"},
     *      summary="Update a given qualification",
     *      operationId="qualification-update",
     *      description="Update a given qualification",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/qualification_id" ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          ref="#/components/schemas/QualificationUpdateRequest"
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function update($qualification_id, QualificationStoreRequest $request)
    {
        $response = $this->qualificationService->updateQualification($qualification_id, $request);

        return $this->sendResponse($response, sprintf('Updated qualification by the id: %s', $qualification_id));
    }

    /**
     * Update a given qualification
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/qualification/{qualification_id}",
     *      tags={"Qualification"},
     *      summary="Delete a given qualification",
     *      operationId="qualification-update",
     *      description="Update a given qualification",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/qualification_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function delete($qualification_id)
    {
        $response = $this->qualificationService->deleteQualification($qualification_id);

        return $this->sendResponse($response, sprintf('Deleted qualification by the id: %s', $qualification_id));
    }

    /**
     * Display a list of students with their evaluation by classroom
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/periods/{classroom_academic_year_id}",
     *      tags={"Qualification"},
     *      summary="List of periods of an academic year of a given classroom",
     *      operationId="academic-periods",
     *      description="Display a list of academic periods for register qualifications",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function periodsIndex($id)
    {
        $response = $this->qualificationService->getListOfPeriodsByClassroomAcademicYear($id);

        return $this->sendResponse($response, sprintf('List of periods by the classroom academic year %s', $id));
    }

    /**
     * Display a list of students with their evaluation by classroom
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/rubrics/{classroom_academic_year_id}",
     *      tags={"Qualification"},
     *      summary="List of rubrics of an academic year of a given classroom",
     *      operationId="rubrics-by-academic-year",
     *      description="Display a list of academic rubrics for register qualifications",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function rubricsIndex($id)
    {
        $response = $this->qualificationService->getListOfAvailableRubricsByClassroomAcademicYear($id);

        return $this->sendResponse($response, sprintf('List of rubrics by the classroom academic year %s', $id));
    }
}
