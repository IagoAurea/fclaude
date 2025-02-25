<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRubricRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\IndicatorRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Http\Requests\ManageClassroomAcademicYearRequest;
use Modules\Evaluation\Exceptions\RubricIndicatorsIsInvalidException;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Evaluation\Services\Interfaces\RubricServiceInterface;
use Modules\Evaluation\Exceptions\RubricHasNoIndicatorsException;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Modules\Evaluation\Http\Requests\EvaluationDateRequest;
use Modules\Evaluation\Http\Requests\UpdateRubricRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Evaluation\Http\Requests\RubricRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Traits\TranslationTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;
use Exception;

class RubricController extends BaseController
{
    use ResourceTrait, TranslationTrait;

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
     * Repository
     *
     * @var $classroomAcademicYearRubric
     */
    protected $classroomAcademicYearRubric;
    
    /**
     * Repository
     *
     * @var $indicatorRepository
     */
    protected $indicatorRepository;
    
    /**
     * Repository
     *
     * @var $alumnRepository
     */
    protected $alumnRepository;
    
    /**
     * Service
     *
     * @var $rubricService
     */
    protected $rubricService;

    /**
     * Instances a new controller class
     *
     * @param RubricRepositoryInterface $rubricRepository
     */
    public function __construct(
        EvaluationResultRepositoryInterface $evaluationResultRepository,
        ClassroomAcademicYearRubricRepositoryInterface $classroomAcademicYearRubric,
        RubricRepositoryInterface $rubricRepository,
        AlumnRepositoryInterface $alumnRepository,
        IndicatorRepositoryInterface $indicatorRepository,
        RubricServiceInterface $rubricService
    ) {
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->classroomAcademicYearRubric = $classroomAcademicYearRubric;
        $this->rubricRepository = $rubricRepository;
        $this->indicatorRepository = $indicatorRepository;
        $this->alumnRepository = $alumnRepository;
        $this->rubricService = $rubricService;
    }

    /**
     * Retrieve all tests created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/evaluation/rubrics/list/user",
     *  tags={"Rubrics"},
     *  summary="List all rubrics created by user authenticate
     *  - Lista todos las rubricas creadas por el usuario",
     *  operationId="list-rubrics-user",
     *  description="List all rubrics created by user authenticate -
     *  Lista todos las rubricas creadas por el usuario",
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
    public function getAllRubricsUser()
    {
        $tests = $this->rubricService->allRubricsByUser(Auth::id());

        return $this->sendResponse($tests, 'List all rubrics of user');
    }

    /**
     * Display a list of rubrics
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics",
     *      tags={"Rubrics"},
     *      summary="Rubrics Index - Rubrics list",
     *      operationId="rubrics-index",
     *      description="Shows a list of rubrics to be included in a rubric of an evaluation",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function index()
    {
        $payload = $this->rubricRepository->findAll();

        return $this->sendResponse($payload, sprintf('List of rubrics'));
    }

    /**
     * Display a list of rubrics by a given classroom
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics-by-classroom/{classroom_academic_year_id}",
     *      tags={"Rubrics"},
     *      summary="Rubrics Index by classroom- Rubrics list by classroom",
     *      operationId="rubrics-index-by-classroom",
     *      description="Shows a list of rubrics to be included in a rubric of an evaluation based on a given classroom",
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
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function indexByClassroom($id)
    {
        try {
            $payload = $this->rubricRepository->findByClassroom($id);

            return $this->sendResponse($payload, sprintf('List of rubrics by classroom academic year %s', $id));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                sprintf('The classroom %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display a list of rubrics by a given classroom
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics-by-user/{user_id}",
     *      tags={"Rubrics"},
     *      summary="Rubrics Index by user - Rubrics list by user",
     *      operationId="rubrics-index-by-user",
     *      description="Shows a list of rubrics to be included in a rubric of an evaluation based on a given user",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/user_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function indexByUser($id)
    {
        try {
            $payload = $this->rubricRepository->findByUser($id);

            return $this->sendResponse($payload, sprintf('List of rubrics by user %s', $id));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                sprintf('The user %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display a list of rubrics by a given alumn
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics-by-alumn/{alumn_id}/classroom/{classroom_academic_year_id}",
     *      tags={"Rubrics"},
     *      summary="Rubrics Index by alumn - Rubrics list by alumn",
     *      operationId="rubrics-index-by-alumn",
     *      description="Shows a list of rubrics to be included in a rubric of an evaluation based on a given alumn",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function indexByAlumn($id, $classroom_academic_year_id)
    {
        try {
            $rubrics = $this->rubricRepository->rubricsByClassroom($classroom_academic_year_id);
            $rubric_ids = $rubrics->pluck('id')->toArray();
            $evaluations = $this->evaluationResultRepository->findByAlumn($rubric_ids, $id, $classroom_academic_year_id);
            $alumn = $this->alumnRepository->find($id);

            $data = collect($rubrics)
                ->map(function ($rubric) use ($evaluations) {
                    $result = $evaluations
                        ->filter(function ($evaluation) use ($rubric) {
                            return $evaluation->evaluation_rubric_id == $rubric->id;
                        })
                        ->first();

                    return [
                        'rubric' => $rubric,
                        'result' => $result ? $result->evaluation_grade : 'N/A',
                    ];
                });

            $payload = [
                'alumn' => $alumn,
                'evaluations' => $data
            ];

            return $this->sendResponse($payload,
                sprintf('List of rubrics by alumn %s and classroom_academic_year_id %s', $id, $classroom_academic_year_id));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                sprintf('The alumn %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display a rubric by a given id
     *
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics/{rubric_id}",
     *      tags={"Rubrics"},
     *      summary="Rubrics Show - Details of a given rubric",
     *      operationId="rubrics-show",
     *      description="Shows the details of a given rubric",
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
    public function show($id)
    {
        $payload = $this->rubricRepository->findBy(['id' => $id]);

        return $this->sendResponse($payload, sprintf('Rubric with the id: %s', $id));
    }

    /**
     * Store a new rubric
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics",
     *      tags={"Rubrics"},
     *      summary="Store rubrics",
     *      operationId="rubrics-store",
     *      description="Stores a new rubric",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/RubricRequest")
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
    public function store(RubricRequest $request)
    {
        $permission = Gate::inspect('store-evaluation-rubric');

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            if (!$request->has('indicators')) {
                throw new RubricHasNoIndicatorsException;
            }

            $indicators = $request->indicators;
            $indicator_ids = [];

            foreach ($indicators as $indicator) {
                $result = $this->indicatorRepository->create($indicator);
                $indicator_ids[] = $result->id;
                $competences = explode(',', $indicator['competences']);

                $this->indicatorRepository->assignCompetencesToIndicator($result->id, $competences);
            }

            $this->rubricService->isValidIndicatorsPercentage($indicator_ids);

            $request['user_id'] = Auth::id();

            $result = $this->rubricRepository->create($request->all());

            $this->rubricRepository->assignIndicatorsToRubric($result->id, $indicator_ids);

            if ($request->has('classroom_academic_year_ids')) {
                $classroom_academic_year_ids = explode(',', $request->classroom_academic_year_ids);
                $this->rubricRepository->assignClassroomsToRubric($result->id, $classroom_academic_year_ids);
            }

            return $this->sendResponse($result, $this->translator('rubric_store'), Response::HTTP_CREATED);
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (RubricHasNoIndicatorsException $exception) {
            return $this->sendError($this->translator('rubric_not_indicators_associated'), $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (RubricIndicatorsIsInvalidException $exception) {
            return $this->sendError($this->translator('indicator_sumatory_percentages') . $exception->getMessage() . '%', [], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_store_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a rubric
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/evaluation/rubrics/{rubric_id}",
     *      tags={"Rubrics"},
     *      summary="Updates rubrics",
     *      operationId="rubrics-update",
     *      description="Updates a rubric",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function update(UpdateRubricRequest $request, $id)
    {
        try {
            $rubric = $this->rubricRepository->findOneBy(['id' => $id]);

            $indicators = $request->indicators;
            $indicator_ids = [];

            foreach ($indicators as $indicator) {
                $result = $this->indicatorRepository->create($indicator);

                $indicator_ids[] = $result->id;

                $competences = [];

                foreach ($indicator['competences'] as $competence) {
                    array_push($competences, $competence['id']);
                }

                $this->indicatorRepository->assignCompetencesToIndicator($result->id, $competences);
            }

            $this->rubricService->isValidIndicatorsPercentage($indicator_ids);

            $this->rubricRepository->assignIndicatorsToRubric($id, $indicator_ids);

            $response = $rubric->update($request->all());

            if ($request->has('classroom_academic_year_ids')) {
                $classroom_academic_year_ids = explode(',', $request->classroom_academic_year_ids);

                $this->rubricRepository->assignClassroomsToRubric($id, $classroom_academic_year_ids);
            }

            return $this->sendResponse($response, $this->translator('rubric_store'));
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (RubricIndicatorsIsInvalidException $exception) {
            return $this->sendError(
                $this->translator('indicator_sumatory_percentages') . $exception->getMessage() . '%',
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_update_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Attach a rubric to a classroom academic year
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics/{rubric_id}/attach-classroom-academic-year",
     *      tags={"Rubrics/Academic Year"},
     *      summary="Attach a rubric to a classroom academic year",
     *      operationId="rubrics-attach-classroom-academic-year",
     *      description="Attach a rubric to a classroom academic year",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ManageClassroomAcademicYearRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function attachClassroomAcademicYear(ManageClassroomAcademicYearRequest $request, $id)
    {
        try {
            $classroom_academic_year_ids = explode(',', $request->classroom_academic_year_ids);
           
            $response = $this->rubricRepository->attachClassroomsToRubric($id, $classroom_academic_year_ids);

            return $this->sendResponse($response, $this->translator('rubric_assign_classroom'));
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_attach_error'),
                $exception->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Detach a rubric to a classroom academic year
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics/{rubric_id}/detach-classroom-academic-year",
     *      tags={"Rubrics/Academic Year"},
     *      summary="Detach a rubric to a classroom academic year",
     *      operationId="rubrics-detach-classroom-academic-year",
     *      description="Detach a rubric to a classroom academic year",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ManageClassroomAcademicYearRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function detachClassroomAcademicYear(ManageClassroomAcademicYearRequest $request, $id)
    {
        try {
            $classroom_academic_year_ids = explode(',', $request->classroom_academic_year_ids);

            $response = $this->rubricRepository->detachClassroomsToRubric($id, $classroom_academic_year_ids);

            return $this->sendResponse($response, $this->translator('rubric_dettach_classroom'));
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while storing the rubric', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Add evaluation date to a rubric on a given classroom academic year
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics/{rubric_id}/classroom-academic-year/{classroom_academic_year_id}/evaluation-date",
     *      tags={"Rubrics/Academic Year"},
     *      summary="Add evaluation date to a rubric on a given classroom academic year",
     *      operationId="rubrics-classroom-academic-year-evaluation-date",
     *      description="Add evaluation date to a rubric on a given classroom academic year",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ManageClassroomAcademicYearRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function evaluationDate(EvaluationDateRequest $request, $rubric_id, $classroom_academic_year_id)
    {
        try {
            $classroom_rubric = $this->classroomAcademicYearRubric->findOneBy([
                'classroom_academic_year_id' => $classroom_academic_year_id,
                'rubric_id' => $rubric_id
            ]);

            if (!$classroom_rubric) {
                throw new ModelNotFoundException;
            }

            $response = $classroom_rubric->update(['evaluation_date' => $request->evaluation_date]);

            return $this->sendResponse($response, $this->translator('evaluation_date_update', [$request->evaluation_date]));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                $this->translator('rubric_classroom_associated_not_found'),
                $exception->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_classroom_associated_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destory a rubric
     *
     * @param int $rubric_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/ages/{rubric_id}",
     *      tags={"Rubrics"},
     *      summary="Destroys a rubric",
     *      operationId="rubrics-destroy",
     *      description="Deletes a rubric",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\Response(
     *          response=204,
     *          ref="#/components/responses/resourceDeleted"
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
    public function destroy($id)
    {
        $response = $this->rubricRepository->findOneBy(['id' => $id]);

        if (!$response) {
            return $this->sendError($this->translator('rubric_not_exist'));
        }

        $response->delete();

        return $this->sendResponse(null, $this->translator('rubric_delete'), Response::HTTP_NO_CONTENT);
    }
}
