<?php

namespace Modules\InjuryPrevention\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Entities
use Modules\Player\Entities\Player;
use Modules\Team\Entities\Team;
use Modules\InjuryPrevention\Entities\InjuryPrevention;

// Services
use Modules\InjuryPrevention\Services\InjuryPreventionEvaluationAnswerService;
use Exception;

class InjuryPreventionEvaluationAnswerController extends BaseController
{
    /**
     * @var object $fileService
     */
    protected $injuryEvaluationAnswerService;

    /**
     * Creates a new controller instance
     */
    public function __construct(InjuryPreventionEvaluationAnswerService $injuryEvaluationAnswerService)
    {   
        $this->injuryEvaluationAnswerService = $injuryEvaluationAnswerService;
    }


    /**
     * Retrieves a listing of closure evaluation questions
     * @return Response
     * 
     * @OA\Post(
     *  path="/api/v1/injury-prevention/{team_id}/players/{player_id}/finalize/{injury_prevention_id}",
     *  tags={"InjuryPrevention"},
     *  summary="Finalizes an injury prevention program",
     *  operationId="finalize-injury-prevention",
     *  description="Saves the answers to an injury prevention evaluation",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/player_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/injury_prevention_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/FinalizeInjuryPreventionRequest"
     *      )
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
    public function store(Request $request, Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        try {
            $response = $this->injuryEvaluationAnswerService->store(
                $request->answers, $injuryPrevention
            );

            return $this->sendResponse($response, 'Injury Prevention Evaluation Successfully Stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by saving injury prevention answers', $exception->getMessage());
        }
    }

    /**
     * Updates an existing set of answers
     * 
     * @return Response
     */
    public function update(Request $request, Team $team, Player $player, InjuryPrevention $injuryPrevention)
    {
        try {
            $this->injuryEvaluationAnswerService->update(
                $request->answers, $injuryPrevention
            );

            return $this->sendResponse(TRUE, 'Injury Prevention Evaluation Successfully Updated', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by saving injury prevention answers', $exception->getMessage());
        }
    }
}
