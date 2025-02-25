<?php

namespace Modules\Evaluation\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Evaluation\Entities\EvaluationResult;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;
use Modules\Evaluation\Http\Requests\EvaluationResultRequest;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Modules\Evaluation\Http\Requests\FinishEvaluationResultRequest;
use Modules\Evaluation\Exceptions\AlumnHasNoGradesRegisteredException;
use Modules\Classroom\Repositories\ClassroomAcademicYearRubricRepository;
use Modules\Evaluation\Exceptions\RubricEvaluationAlreadyFinishedException;
use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\Qualification\Services\Interfaces\QualificationServiceInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Qualification\Repositories\Interfaces\QualificationResultRepositoryInterface;

class EvaluationResultController extends BaseController
{
    use TranslationTrait;
    
    /**
     * Repository
     *
     * @var $evaluationResultRepository
     */
    protected $evaluationResultRepository;

    /**
     * Repository
     *
     * @var $classroomAcademicYearRubricRepository
     */
    protected $classroomAcademicYearRubricRepository;
    
    /**
     * Repository
     *
     * @var $qualificationResultRepository
     */
    protected $qualificationResultRepository;

    /**
     * Services
     *
     * @var $evaluationResultService
     */
    protected $evaluationResultService;

    /**
     * Services
     *
     * @var $qualificationService
     */
    protected $qualificationService;

    /**
     * Instances a new controller class
     *
     * @param EvaluationResultRepositoryInterface $evaluationResultRepository
     */
    public function __construct(
        EvaluationResultRepositoryInterface $evaluationResultRepository,
        EvaluationResultServiceInterface $evaluationResultService,
        ClassroomAcademicYearRubricRepository $classroomAcademicYearRubricRepository,
        QualificationServiceInterface $qualificationService,
        QualificationResultRepositoryInterface $qualificationResultRepository
    ) {
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->evaluationResultService = $evaluationResultService;
        $this->classroomAcademicYearRubricRepository = $classroomAcademicYearRubricRepository;
        $this->qualificationService = $qualificationService;
        $this->qualificationResultRepository = $qualificationResultRepository;
    }

    /**
     * Get a new evaluation result to a player in a rubric
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/result",
     *      tags={"Evaluations"},
     *      summary="Get the result of a rubric evaluations",
     *      operationId="evaluation-result-preview",
     *      description="Get the evaluation result",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/EvaluationResultRequest")
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
    public function getResult(EvaluationResultRequest $request)
    {
        try {
            $result = $this->evaluationResultService
                ->getResult($request->rubric_id, $request->alumn_id, $request->classroom_academic_year_id);

            return $this->sendResponse($result, 'Rubric evaluation result');
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError('The rubric does not exist', $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (AlumnHasNoGradesRegisteredException $exception) {
            return $this->sendError('The alumn has no grades registered',
                $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while fetching the evaluation result',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the evaluation result by competences of a player in a rubric
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/competences-result",
     *      tags={"Evaluations"},
     *      summary="Get the evaluation result by competences of a player in a rubric",
     *      operationId="evaluation-result-by-competence",
     *      description="Get the evaluation result by competences of a player in a rubric",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/EvaluationResultRequest")
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
    public function getCompetenceResult(EvaluationResultRequest $request)
    {
        try {
            $result = $this->evaluationResultService
                ->getResultByCompetences($request->rubric_id, $request->alumn_id, $request->classroom_academic_year_id);

            return $this->sendResponse($result,
                sprintf('Rubric evaluation result by competences for alumn %s on rubric %s',
                $request->alumn_id, $request->rubric_id));
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError('The rubric does not exist', $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (AlumnHasNoGradesRegisteredException $exception) {
            return $this->sendError('The alumn has no grades registered',
                $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while fetching the evaluation result by competences',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Finish a evaluation of a rubric
     * for a alumn in a given
     * classroom and stores
     * it in the db
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/finish",
     *      tags={"Evaluations"},
     *      summary="Finish evaluations",
     *      operationId="evaluation-finish",
     *      description="Finish a new evaluation result and stores the data",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/FinishEvaluationResultRequest")
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
    public function finish(FinishEvaluationResultRequest $request)
    {
        try {
            $result = $this->evaluationResultRepository->findOrCreate([
                'alumn_id' => $request->alumn_id,
                'classroom_academic_year_id' => $request->classroom_academic_year_id,
                'evaluation_rubric_id' => $request->rubric_id
            ]);

            // if ($result->status === EvaluationResult::STATUS_EVALUATED) {
            //     throw new RubricEvaluationAlreadyFinishedException;
            // }

            $scores = $this->evaluationResultService->getResult(
                    $request->rubric_id,
                    $request->alumn_id,
                    $request->classroom_academic_year_id
                );

            $payload = [
                'user_id' => $request->user('api')->id,
                'evaluation_grade' => number_format($scores['score'], 2),
                'status' => EvaluationResult::STATUS_EVALUATED
            ];

            $result->update($payload);

            $evaluation = $this->classroomAcademicYearRubricRepository
                ->findOneBy([
                    'classroom_academic_year_id' => $request->classroom_academic_year_id,
                    'rubric_id' => $request->rubric_id
                ]);

            $evaluation->update(['status' => ClassroomAcademicYearRubric::STATUS_EVALUATED]);

            $item = $this->qualificationService->getPercentage($request->rubric_id);

            if ($item) {
                $qualificationGrade = $this->qualificationService->generateQualificationGrade(
                    $item->percentage,
                    $scores['score']
                );

                if ($qualificationGrade) {
                    $evaluationCompetence = $this->evaluationResultService
                        ->getResultByCompetences(
                            $request->rubric_id,
                            $request->alumn_id,
                            $request->classroom_academic_year_id,
                            $item->percentage
                        );
                    
                    $this->qualificationResultRepository->updateOrCreate([
                        'qualification_id' => $item->qualification_id,
                        'qualification_item_id' => $item->id,
                        'alumn_id' => $result->alumn_id
                    ], [
                        'result' => $qualificationGrade,
                        'competence_score' => json_encode($evaluationCompetence)
                    ]);
                }
            }

            return $this->sendResponse($result, $this->translator('alumn_evaluation_result'), Response::HTTP_CREATED);
        } catch (RubricEvaluationAlreadyFinishedException $exception) {
            return $this->sendError($this->translator('alumn_already_evaluated_rubric_classroom'),
                $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (AlumnHasNoGradesRegisteredException $exception) {
            return $this->sendError($this->translator('alumn_not_grade_registered'), $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while storing the evaluation result',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
