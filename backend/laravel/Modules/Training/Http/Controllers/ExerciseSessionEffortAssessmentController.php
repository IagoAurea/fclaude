<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreExerciseSessionEffortAssessmentRequest;
use Modules\Training\Repositories\Interfaces\ExerciseSessionEffortAssessmentRepositoryInterface;

class ExerciseSessionEffortAssessmentController extends BaseController
{
    /**
     * @var $effortAssessmentRepository
     */
    protected $effortAssessmentRepository;


    public function __construct(
        ExerciseSessionEffortAssessmentRepositoryInterface $effortAssessmentRepository
    )
    {
        $this->effortAssessmentRepository = $effortAssessmentRepository;
    }

    
    /**
    * @OA\Post(
    *       path="/api/v1/training/effort-assessments/exercise-sessions",
    *       tags={"ExerciseSession"},
    *       summary="Stored Effort Assessments - guardar una nueva evaluación del esfuerzo en la sesión ",
    *       operationId="exercise-sessions-effort-store",
    *       description="Store a Effort Assessments - Guarda una nueva  evaluación del esfuerzo en la sesión ",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreExerciseSessionEffortAssessmentRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Store a new Exercise Session.
     * @param StoreExerciseSessionEffortAssessmentRequest $request
     * @return Response
     */
    public function store(StoreExerciseSessionEffortAssessmentRequest $request)
    {
        try {
            $effortAssessment = $this->effortAssessmentRepository->createEffortAssessment($request);

            return $this->sendResponse($effortAssessment, 'Effort Assessment stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Effort Assessment', $exception->getMessage());
        }
    }
}
