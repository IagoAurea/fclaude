<?php

namespace Modules\AlumnControl\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Alumn\Entities\Alumn;
use Modules\Classroom\Entities\Classroom;
use App\Http\Controllers\Rest\BaseController;
use Modules\AlumnControl\Services\DailyControlService;
use Modules\AlumnControl\Http\Requests\StoreDailyControlAlumnRequest;
use Modules\AlumnControl\Http\Requests\UpdateDailyControlAlumnRequest;
use Modules\AlumnControl\Http\Requests\ResetDailyControlAlumnRequest;

class DailyControlController extends BaseController
{
    /**
     * @var object
     */
    protected $controlService;

    /**
     * Create a new controller instance
     */
    public function __construct(
        DailyControlService $controlService
    ) {
        $this->controlService = $controlService;
    }

    /**
     * Retrieves a listing of all players with injury prevention items
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/daily-control/{classroom_id}",
     *  tags={"Alumn/DailyControl"},
     *  summary="Daily Control Index",
     *  operationId="list-classroom-daily-control-alumns",
     *  description="Returns a list of all alumns belonging to an specific classroom-year with all their daily control annotations",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_academic_year_id_daily_control_list"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/academic_period_id_daily_control_list"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/qs_date"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all alumns with daily control item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlAlumnListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Request $request, Classroom $classroom)
    {
        $this->controlService->getTimelapseItems($request->all(), $classroom, false, false);

        try {
            $dailyRecords = $this->controlService->list($request->all(), $classroom);

            return $this->sendResponse($dailyRecords, 'Daily records on classroom');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving alumn daily control list', $exception->getMessage());
        }
    }

    /**
     * Inserts a set of daily control items refer to an alumn
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/daily-control/{classroom_id}",
     *  tags={"Alumn/DailyControl"},
     *  summary="Daily Control Store",
     *  operationId="store-classroom-daily-control-alumns",
     *  description="Inserts for first time an alumn control set of items",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreDailyControlAlumnRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Stored alumn daily control",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlAlumnStoreResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(StoreDailyControlAlumnRequest $request, Classroom $classroom)
    {
        $this->controlService->getTimelapseItems($request->all(), $classroom, false);

        try {
            $this->controlService->store($request->all());

            return $this->sendResponse(false, 'Stored alumn daily control');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing alumn daily control', $exception->getMessage());
        }
    }

    /**
     * Retrieves single player with
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/daily-control/{classroom_id}/show/{alumn_id}",
     *  tags={"Alumn/DailyControl"},
     *  summary="Daily Control Alumn Details",
     *  operationId="list-classroom-daily-control-alumn-details",
     *  description="Returns a list of all daily control annotations from an specific alumn",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/alumn_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_academic_year_id_daily_control_list"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/academic_period_id_daily_control_list"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/qs_date"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all alumns with daily control item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlAlumnDetailsResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(Request $request, Classroom $classroom, Alumn $alumn)
    {
        $control = $this->controlService->show($request->all(), $classroom, $alumn);

        return $this->sendResponse($control, 'Daily Control Data');
    }

    /**
     * Updates a set of daily control items refer to an alumn
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/daily-control/{classroom_id}",
     *  tags={"Alumn/DailyControl"},
     *  summary="Daily Control Update",
     *  operationId="update-classroom-daily-control-alumns",
     *  description="Updates an alumn control set of items",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateDailyControlAlumnRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Updated alumn daily control",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlAlumnUpdateResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateDailyControlAlumnRequest $request, Classroom $classroom)
    {
        $this->controlService->getTimelapseItems($request->all(), $classroom, false);

        try {
            $updated = $this->controlService->update($request->all(), $classroom);

            return $this->sendResponse($updated, 'Updated alumn daily control');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating alumn daily control',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Resets a set of daily control items refer to an alumn
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/daily-control/{classroom_id}/reset",
     *  tags={"Alumn/DailyControl"},
     *  summary="Daily Control Reset",
     *  operationId="reset-classroom-daily-control-alumns",
     *  description="Resets an alumn control set of items",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/classroom_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ResetDailyControlAlumnRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Updated alumn daily control",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DailyControlAlumnResetResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function reset(ResetDailyControlAlumnRequest $request, Classroom $classroom)
    {
        $this->controlService->getTimelapseItems($request->all(), $classroom, false);

        try {
            $result = $this->controlService->reset($request->all(), $classroom);

            return $this->sendResponse($result, 'Daily control successfully reseted');
        } catch (Exception $exception) {
            return $this->sendError('Error by reseting alumn daily control', $exception->getMessage());
        }
    }
}
