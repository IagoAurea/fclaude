<?php

namespace Modules\InjuryPrevention\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\InjuryPrevention\Repositories\Interfaces\EvaluationQuestionRepositoryInterface;

class EvaluationQuestionController extends BaseController
{
    /**
     * @var object $fileService
     */
    protected $evaluationQuestionRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(EvaluationQuestionRepositoryInterface $evaluationQuestionRepository)
    {   
        $this->evaluationQuestionRepository = $evaluationQuestionRepository;
    }


    /**
     * Retrieves a listing of closure evaluation questions
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/injury-prevention/evaluation-questions",
     *  tags={"InjuryPrevention"},
     *  summary="Retrieves all evaluation questions",
     *  operationId="injury-prevention-evaluation-questions",
     *  description="Returns a list of all evaluation questions",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function index()
    {
        $questions = $this->evaluationQuestionRepository->findAllTranslated();

        return $this->sendResponse($questions, 'List Injury Prevention Closure Questions');
    }
}
