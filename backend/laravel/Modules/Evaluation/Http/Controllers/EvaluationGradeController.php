<?php

namespace Modules\Evaluation\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Evaluation\Http\Requests\EvaluationGradeRequest;
use Modules\Evaluation\Services\Interfaces\EvaluationGradeServiceInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationGradeRepositoryInterface;

class EvaluationGradeController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * 
     * @var $evaluationGradeRepository
     */
    protected $evaluationGradeRepository;

    /**
     * Service
     *
     * @var $evaluationGradeService
     */
    protected $evaluationGradeService;

    /**
     * Instances a new controller class
     *
     * @param EvaluationGradeRepositoryInterface $evaluationGradeRepository
     */
    public function __construct(
        EvaluationGradeRepositoryInterface $evaluationGradeRepository,
        EvaluationGradeServiceInterface $evaluationGradeService
    )
    {
        $this->evaluationGradeRepository = $evaluationGradeRepository;
        $this->evaluationGradeService = $evaluationGradeService;
    }

     /**
     * Retrieve all evaluations created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/evaluation/grade/list/user",
     *  tags={"Evaluations"},
     *  summary="List all evaluations created by user authenticate
     *  - Lista todos las evaluaciones por el usuario",
     *  operationId="list-tests-classroom-user",
     *  description="List all evaluations created by user authenticate -
     *  Lista todos las evaluaciones por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllEvaluationsUser()
    {
        $evaluations = $this->evaluationGradeService->allEvaluationsByUser(Auth::id());

        return $this->sendResponse($evaluations, 'List all evaluations of user');
    }

    /**
     * Store a new evaluation result to a alumn in a rubric
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/grade",
     *      tags={"Evaluations"},
     *      summary="Store evaluations grades",
     *      operationId="evaluation-grade-store",
     *      description="Stores a new evaluation result",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/EvaluationGradeRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          ref="#/components/responses/responseCreated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function store(EvaluationGradeRequest $request)
    {
        $exist = $this->evaluationGradeRepository->findOneBy([
            'alumn_id' => $request->alumn_id,
            'classroom_academic_year_id' => $request->classroom_academic_year_id,
            'indicator_rubric_id' => $request->indicator_rubric_id
        ]);

        if ($exist) {
            $exist->update($request->all());
            return $this->sendResponse(true, $this->translator('evaluation_grade_update'));
        }

        try {
            $result = $this->evaluationGradeRepository->create($request->all());

            return $this->sendResponse($result, $this->translator('evaluation_grade_store'), Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError($this->translator('evaluation_grade_error'),
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
