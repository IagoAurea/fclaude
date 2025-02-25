<?php

namespace Modules\Qualification\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Request;
use Modules\Qualification\Services\Interfaces\QualificationResultServiceInterface;

class QualificationResultController extends BaseController
{
    /**
     * Service
     *
     * @var $qualificationResultsService
     */
    protected $qualificationResultsService;

    /**
     * Instances a new controller class
     *
     */
    public function __construct(
        QualificationResultServiceInterface $qualificationResultsService
    ) {
        $this->qualificationResultsService = $qualificationResultsService;
        ini_set('max_execution_time', 0);
    }

    /**
     * Display a list of qualifications
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/results/school-section/{classroom_academic_year_id}",
     *      tags={"Qualification"},
     *      summary="List of qualifications results of an academic year of a given classroom",
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
        $response = $this->qualificationResultsService->classroom($classroom_academic_year_id);

        return $this->sendResponse($response,
            sprintf('List of qualifications results by the classroom academic year %s', $classroom_academic_year_id));
    }

    /**
     * Display a detail of result qualifications of alumn by classroom academic year
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/{qualification_req_id}/alumns/{alumn_id}/school-section/{classroom_academic_year_id}",
     *      tags={"Qualification"},
     *      summary="Detail qualifications results of an academic year of a given classroom by alumn",
     *      operationId="qualification-alumn-show",
     *      description="Display a list of qualifications by alumn",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/qualification_req_id" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
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
    public function show($qualification_id, $alumn_id, $classroom_academic_year_id)
    {
        $response = $this->qualificationResultsService->qualificationAlumnByClassroom(
            $qualification_id, $alumn_id, $classroom_academic_year_id
        );

        return $this->sendResponse($response,
            sprintf('Show qualifications of alumn by the classroom academic year %s', $classroom_academic_year_id)
        );
    }
}
