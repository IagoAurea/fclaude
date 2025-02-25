<?php

namespace Modules\Injury\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Injury\Services\RfdService;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Auth;
use Modules\Injury\Http\Requests\StorePhaseDetailRequest;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\PhaseRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\PhaseDetailRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;

class PhaseDetailController extends BaseController
{

    /**
     * @var $phaseRepository
     */
    protected $phaseRepository;

    /**
     * @var $phaseDetailRepository
     */
    protected $phaseDetailRepository;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var $rfdService
     */
    protected $rfdService;

    public function __construct(
        PhaseRepositoryInterface $phaseRepository,
        PhaseDetailRepositoryInterface $phaseDetailRepository,
        TestRepositoryInterface $testRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        RfdService $rfdService
    ) {
        $this->phaseRepository = $phaseRepository;
        $this->phaseDetailRepository = $phaseDetailRepository;
        $this->testRepository = $testRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->rfdService = $rfdService;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/phase-detail/{code}",
     *       tags={"Injury"},
     *       summary="Get Test By Phase Detail- Obtener el test para un detalle de fase",
     *       operationId="get-test-phase-detail",
     *       description="Return data test by phase detail  - Obtener el test para un detalle de fase",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show Test specified resource.
     * @param int $code
     * @return Response
     */
    public function getTestByPhase($code, Request $request)
    {
        try {
            $phaseDetail = $this->phaseDetailRepository->findOneBy(["code" => $code]);

            if (!$phaseDetail) {
                return $this->sendError("Error", "Phase Detail not found", Response::HTTP_NOT_FOUND);
            }

            // TODO: getTestBySportId
            $test_id = $this->rfdService->getTestId($phaseDetail->id);

            $test = $this->testRepository->findTestAll($test_id, $request->get('_locale'))->toArray();

            $application = $this->testApplicationRepository->findOneBy([
                'applicable_id' => $phaseDetail->id,
                'applicable_type' => 'Modules\Injury\Entities\PhaseDetail'
            ]);

            if ($application) {
                $application_data = $this->testApplicationRepository->findTestApplicationAll($application->id);
                $test['previous_application'] = $application_data;
            }

            return $this->sendResponse($test, 'Test By Phase');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test ', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/injuries/phase-detail/{code}",
     *       tags={"Injury"},
     *       summary="Evaluate Phase - Evaluar Fase ",
     *       operationId="evaluate-phase-detail",
     *       description="Evaluate a phase detail - Evaluar un detalle de fase ",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StorePhaseDetailRequest")
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
     * Show Test specified resource.
     * @param StorePhaseDetailRequest $request
     * @param int $code
     * @return Response
     */
    public function evaluatePhase(StorePhaseDetailRequest $request, $code)
    {
        try {
            $phaseDetail = $this->phaseDetailRepository->findOneBy(["code" => $code]);

            if (!$phaseDetail) {
                return $this->sendError("Error", "Phase Detail not found", Response::HTTP_NOT_FOUND);
            }

            $this->phaseDetailRepository->update($request->except(['answers', 'test_passed']), $phaseDetail);
            
            $request['user_id'] = Auth::id();
            
            $phaseAdvance = $this->rfdService->evaluatePhase($phaseDetail->id, $request->all());
            
            return $this->sendResponse($phaseAdvance, 'Phase Advance');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving calculate Phase Advance', $exception->getMessage());
        }
    }
}
