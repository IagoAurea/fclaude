<?php

namespace Modules\EffortRecovery\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use app\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\EffortRecovery\Http\Requests\StoreQuestionnaireRequest;
use Modules\EffortRecovery\Http\Requests\UpdateQuestionnaireRequest;
use Modules\EffortRecovery\Services\WellnessQuestionnaireHistoryService;

class WellnessQuestionnaireHistoryController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $historyService
     */
    protected $historyService;

    /**
     * Creates a new controller instance
     */
    public function __construct(WellnessQuestionnaireHistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    /**
     * Return the history items related to an effort program
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/effort-recovery/questionnaire/{effort_recovery_id}/history",
     *  tags={"EffortRecovery/WellnessQuestionnaire"},
     *  summary="Wellness Questionnaire History Index Endpoint - Endpoint de Listado de Historico de Cuestionario",
     *  operationId="index-wellness-questionnaire-history",
     *  description="Lists an historic list of all questionnaires made to an effort recovery program
     *  Lista un historico de todos los cuestionarios hechos a un programa de recuperacion del esfuerzo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
    */
    public function index($effortId)
    {
        try {
            $historyList = $this->historyService->index($effortId);
            return $this->sendResponse($historyList, 'Effort Program History List');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving historic answers',
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * Saves a set of answers in a historic item of recovery program
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/effort-recovery/questionnaire/{effort_recovery_id}",
     *  tags={"EffortRecovery/WellnessQuestionnaire"},
     *  summary="Wellness Questionnaire Creation Endpoint - Endpoint de Creacion de Cuestionario",
     *  operationId="store-wellness-questionnaire",
     *  description="Inserts a new effort recovery program questionnaire to the database
     *  Inserta un nuevo cuestionario de programa de recuperacion del esfuerzo",     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreQuestionnaireRequest"
     *      )
     *  ),
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
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
     */
    public function store(StoreQuestionnaireRequest $request, $effortId)
    {
        try {
            $historyItem = $this->historyService->store($request->all(), $effortId);
            return $this->sendResponse($historyItem, $this->translator('questionnarie_controller_store_response_message'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by saving questionnaire answers',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update a set of answers in a historic item of recovery program
     * @return Response
     * 
     * @OA\Put(
     *  path="/api/v1/effort-recovery/{effort_recovery_id}/questionnaire/{questionnaire_id}",
     *  tags={"EffortRecovery/WellnessQuestionnaire"},
     *  summary="Wellness Questionnaire Update Endpoint - Endpoint de Actualizacion de Cuestionario",
     *  operationId="update-wellness-questionnaire",
     *  description="Update a new effort recovery program questionnaire to the database - Actualiza un nuevo cuestionario de programa de recuperacion del esfuerzo",     
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/effort_recovery_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/questionnaire_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreQuestionnaireRequest"
     *      )
     *  ),
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
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
     */
    public function update(UpdateQuestionnaireRequest $request, $effortId, $questionnarieId)
    {
        try {
            $history = $this->historyService->update($request->all(), $effortId, $questionnarieId);

            return $this->sendResponse($history, $this->translator('questionnarie_controller_update_response_message'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by update questionnaire answers',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
