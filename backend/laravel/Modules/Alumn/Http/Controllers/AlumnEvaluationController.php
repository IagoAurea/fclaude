<?php

namespace Modules\Alumn\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Alumn\Services\AlumnService;
use App\Traits\TranslationTrait;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AlumnEvaluationController extends BaseController
{
    use TranslationTrait;
    /**
     * @var $alumnService
     */
    protected $alumnService;

    /**
     * Creates a new controller instance
     */
    public function __construct(AlumnService $alumnService)
    {
        $this->alumnService = $alumnService;
    }

    /**
     * Resume of evaluations for an alumn in a given classroom academic year
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/alumns/resumes/classroom/{classroom_academic_year_id}",
     *  tags={"Alumn"},
     *  summary="Resume of evaluations of all allumns in a given classroom academic year -
     *  Resumen de evaluaciones de un alumno en un salon de clase",
     *  operationId="alumn-evaluations-resumes",
     *  description="Resume of evaluations for all alumns in a given classroom academic year",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *  @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
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
    public function resumes($classroom_academic_year_id)
    {
        try {
            $response = $this->alumnService->resumes($classroom_academic_year_id);

            return $this->sendResponse($response, $this->translator('alumn_evaluation_resume'));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                $this->translator('alumn_not_found'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('alumn_evaluation_resume_error'),
                $exception->getMessage(), Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Resume of evaluations for an alumn in a given classroom academic year
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/alumns/resume/{alumn_id}/classroom/{classroom_academic_year_id}",
     *  tags={"Alumn"},
     *  summary="Resume of evaluations of an alumn in a given classroom academic year -
     *  Resumen de evaluaciones de un alumno en un salon de clase",
     *  operationId="alumn-evaluations-resume",
     *  description="Resume of evaluations for an alumn in a given classroom academic year",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *  @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
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
    public function resume($alumn_id, $classroom_academic_year_id)
    {
        try {
            $response = $this->alumnService->resume($alumn_id, $classroom_academic_year_id);

            return $this->sendResponse($response, $this->translator('alumn_evaluation_resume'));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(
                $this->translator('alumn_not_found'), $exception->getMessage(),Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('alumn_evaluation_resume_error'),
                $exception->getMessage(), Response::HTTP_BAD_REQUEST
            );
        }
    }
}
