<?php

namespace Modules\Nutrition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Services\NutritionService;
use Modules\Nutrition\Http\Requests\AthleteActivityCalculationRequest;
use Modules\Nutrition\Repositories\Interfaces\AthleteActivityRepositoryInterface;



class AthleteActivityController extends BaseController
{
    /**
     * @var $nutritionalSheetRepository
     */
    protected $athleteActivityRepository;

    /**
     * @var $nutritionService
     */
    protected $nutritionService;


    public function __construct(
        AthleteActivityRepositoryInterface $athleteActivityRepository,
        NutritionService $nutritionService
    )
    {
        $this->athleteActivityRepository = $athleteActivityRepository;
        $this->nutritionService = $nutritionService;
    }
    

    /**
    * @OA\Post(
    *       path="/api/v1/nutrition/athlete-activity-factor",
    *       tags={"Nutrition"},
    *       summary="Calculate Activity factors - Calcula los factores de actividad ",
    *       operationId="activity-factors-calculate",
    *       description="Calculate Activity factors - Calcula los factores de actividad",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/AthleteActivityCalculationRequest")
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
     * Calculate the Athlete Activity factor.
     * @param AthleteActivityCalculationRequest $request
     * @return Response
     */
    public function getCalculationAthleteActivityFactor(AthleteActivityCalculationRequest $request)
    {
      
        $athleteActivityCalculation = $this->nutritionService
            ->athleteActivityCalculation(
                $request->only('repose','very_light','light','moderate','intense'), $request->player_id);
    
        if (!$athleteActivityCalculation['success']) {
            return $this->sendError('Error by Calculate Athlete activity', $athleteActivityCalculation['message']);
        }
        return $this->sendResponse($athleteActivityCalculation['data'], 'Athlete activity Calculation');
    }


}
