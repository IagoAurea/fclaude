<?php

namespace Modules\Alumn\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Exception;

// External services
use Modules\Health\Services\HealthService;
use Modules\Health\Services\SurgeryService;

// Requests
use Modules\Alumn\Http\Requests\HealthStatusRequest;

// Entities
use Modules\Alumn\Entities\Alumn;

class AlumnHealthController extends BaseController
{
    /**
     * @var array
     */
    const EXCEPTING_VALUES = [
        '_lang',
        'surgeries',
    ];

    /**
     * @var object
     */
    protected $healthService;

    /**
     * @var object
     */
    protected $surgeryService;

    /**
     * Instance a controller class
     */
    public function __construct(
        HealthService $healthService,
        SurgeryService $surgeryService
    ) {
        $this->healthService = $healthService;
        $this->surgeryService = $surgeryService;
    }

    /**
     * Gets the current health status of the alumn
     *
     * @param Integer $id
     * @return Response
     */
    public function viewHealthStatus(Alumn $alumn)
    {
        $alumn_health_status = [
            'diseases' => $alumn->diseases,
            'allergies' => $alumn->allergies,
            'body_areas' => $alumn->bodyAreas,
            'physical_problems' => $alumn->physicalProblems,
            'medicine_types' => $alumn->medicineTypes,
            'tobacco_consumptions' => $alumn->tobaccoConsumptions[0] ?? null,
            'alcohol_consumptions' => $alumn->alcoholConsumptions[0] ?? null,
            'surgeries' => $alumn->surgeries,
        ];

        return $this->sendResponse($alumn_health_status, 'Alumn Health Information');
    }

    /**
     * Manages all alumn's health relationships
     * @param HealthStatusRequest
     * @return Response
     */
    public function manageHealthStatus(HealthStatusRequest $request, Alumn $alumn)
    {
        try {
            $health_items = $request->except(self::EXCEPTING_VALUES);

            $this->healthService->updateHealthStatus($alumn, $health_items);

            $this->surgeryService->manageSurgeries($alumn, $request->surgeries);

            return $this->sendResponse(null, 'Alumn Health Status Updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating alumn health status', $exception->getMessage());
        }
    }
}
