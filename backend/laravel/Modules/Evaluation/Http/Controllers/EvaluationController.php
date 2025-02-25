<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Entities\EvaluationResult;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Request;

class EvaluationController extends BaseController
{
    /**
     * Repository
     * 
     * @var $rubricRepository
     */
    protected $rubricRepository;

    /**
     * Repository
     * 
     * @var $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    /**
     * Instances a new controller class
     * 
     * @param ClassroomRepositoryInterface $evaluationResultRepository
     * @param RubricRepositoryInterface $rubricRepository
     */
    public function __construct(
        EvaluationResultRepositoryInterface $evaluationResultRepository,
        RubricRepositoryInterface $rubricRepository
    ) {
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->rubricRepository = $rubricRepository;
    }

    /**
     * Display a list of students with their evaluation by classroom
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/last-evaluations-by-classroom/{classroom_academic_year_id}",
     *      tags={"Evaluation"},
     *      summary="Evaluations Index by classroom",
     *      operationId="students-evaluation-by-classroom",
     *      description="Display a list of last evaluations by classroom",
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
    public function lastEvaluationsByClassroom($id)
    {
        $payload = $this->evaluationResultRepository->latestEvaluationsAlumns($id);
           
        return $this->sendResponse($payload, 'List of evaluations by classroom');
    }

    /**
     * Display a list of students with their evaluation by classroom
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/students-evaluation-by-classroom/{classroom_id}",
     *      tags={"Evaluation"},
     *      summary="Students Index by classroom",
     *      operationId="students-evaluation-by-classroom",
     *      description="Display a list of students with their evaluation by classroom",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_id" ),
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
    public function indexByClassroom($id)
    {
        $payload = $this->evaluationResultRepository->findBy(['classroom_academic_year_id' => $id]);

        return $this->sendResponse($payload,'List of students by classroom');
    }

    /**
     * Display a list of students with their evaluation by classroom
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/students-evaluation-by-rubric/{rubric_id}",
     *      tags={"Evaluation"},
     *      summary="Students Index by rubric",
     *      operationId="students-evaluation-by-rubric",
     *      description="Display a list of students with their evaluation by rubric",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
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
    public function indexByRubric($id)
    {
        $payload = $this->evaluationResultRepository->findBy(['rubric_id' => $id]);

        return $this->sendResponse($payload, 'List of students by rubric');
    }
}
