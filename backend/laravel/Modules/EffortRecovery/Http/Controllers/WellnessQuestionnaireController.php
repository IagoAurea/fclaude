<?php

namespace Modules\EffortRecovery\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\EffortRecovery\Services\WellnessQuestionnaireService;
use Exception;

class WellnessQuestionnaireController extends BaseController
{
    /**
     * @var $questionnaireService
     */
    protected $questionnaireService;

    /**
     * Creates a new controller instance
     */
    public function __construct(WellnessQuestionnaireService $questionnaireService)
    {
        $this->questionnaireService = $questionnaireService;
    }

    /**
     * Retrieves all the types of answers
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/questionnaire/types",
     *  tags={"EffortRecovery/WellnessQuestionnaire"},
     *  summary="Wellness Questionnaire Types Index Endpoint - Endpoint de Listado Tipos de Pregunta de Cuestionario",
     *  operationId="list-wellness-questionnaire-types",
     *  description="Returns a list of all types related to the questionnaire answers
     *  Obtiene un listado de los tipos de respuestas que existen para las respuestas de cuestionario",
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
    public function indexTypes()
    {
        try {
            $strategies = $this->questionnaireService->listTypes();
            return $this->sendResponse($strategies, 'List of Questionnaire Answer Types');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by listing questionnaire answer types',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    /**
     * Retrieves all the answers depending on the type sent
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/effort-recovery/questionnaire/items/{questionnaire_item_type}",
     *  tags={"EffortRecovery/WellnessQuestionnaire"},
     *  summary="Wellness Questionnaire Answer Items Index Endpoint - Endpoint de Listado de Respuestas de Questionario",
     *  operationId="list-wellness-questionnaire-items-types",
     *  description="Returns a list of all answers depending on the type sent
     *  Obtiene un listado de las respuesas que existen para un questionario segun el tipo correspondiente",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/questionnaire_item_type"
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
    public function indexItems($typeId)
    {
        try {
            $strategies = $this->questionnaireService->listItems($typeId);
            return $this->sendResponse($strategies, 'List of Questionnare Answers');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by listing questionnaire answers',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
