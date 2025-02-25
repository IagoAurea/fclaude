<?php

namespace Modules\Fisiotherapy\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\Fisiotherapy\Services\DailyWorkService;
use Modules\Fisiotherapy\Http\Requests\StoreDailyWorkRequest;
use Modules\Fisiotherapy\Http\Requests\UpdateDailyWorkRequest;

class DailyWorkController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object $fileService
     */
    protected $dailyWorkService;

    /**
     * Creates a new controller instance
     */
    public function __construct(DailyWorkService $dailyWorkService)
    {
        $workList = $this->dailyWorkService = $dailyWorkService;

        return $this->sendResponse($workList, 'Daily Work List');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($teamId, $playerId, $fileId)
    {

        try {
            $works = $this->dailyWorkService->dailyWorkList($fileId);

            return $this->sendResponse($works, 'Daily Work List', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by listing daily works', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/fisiotherapy/{team_id}/players/{player_id}/files/{file_id}/daily-work",
     *       tags={"Fisiotherapy/Daily Work"},
     *       summary="Stores a file daily work - Guardar registro de trabajo diario",
     *       operationId="daily-work-store",
     *       description="Create daily work registry of player file - Crear registro de trabajo diario de una ficha",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
     *       @OA\Parameter( ref="#/components/parameters/file_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/FisiotherapyStoreDailyWorkRequest")
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
     * Stores a new daily work item
     * @param $request
     * @param $teamId
     * @param $playerId
     * @param $fieldId
     * @return Response
     */
    public function store(StoreDailyWorkRequest $request, $teamId, $playerId, $fileId)
    {
        try {
            $work = $this->dailyWorkService->store($request->all(), $fileId);

            return $this->sendResponse($work,
             $this->translator('daily_work_controller_store_response_message'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by inserting daily work', $exception->getMessage());
        }
    }

    /**
     * Retrieves information about specific daily work
     *
     * @return Response
     */
    public function show($teamId, $playerId, $fileId, $dailyWorkId)
    {
        try {
            $work =  $this->dailyWorkService->find($dailyWorkId);

            return $this->sendResponse($work, 'Daily Work information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving daily work', $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *       path="/api/v1/fisiotherapy/{team_id}/players/{player_id}/files/{file_id}/daily-work/{daily_work_id}",
     *       tags={"Fisiotherapy/Daily Work"},
     *       summary="Update a file daily work - Actualizar registro de trabajo diario",
     *       operationId="daily-work-update",
     *       description="Update daily work registry of player file -
     *       Actualiza registro de trabajo diario de una ficha",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
     *       @OA\Parameter( ref="#/components/parameters/file_id" ),
     *       @OA\Parameter( ref="#/components/parameters/daily_work_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/FisiotherapyUpdateDailyWorkRequest")
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
     * Updates information about a daily work registry
     *
     * @return Response
     */
    public function update(UpdateDailyWorkRequest $request, $teamId, $playerId, $fileId, $dailyWorkId)
    {
        try {
            $work = $this->dailyWorkService->update($request->all(), $dailyWorkId);

            return $this->sendResponse($work, $this->translator('daily_work_controller_store_response_message'));
        } catch (Exception $exception) {
            return $this->sendError('Error by updating daily work',
             $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a daily work registry
     *
     * @return Response
     */
    public function destroy($teamId, $playerId, $fileId, $dailyWorkId)
    {
        try {
            $this->dailyWorkService->destroy($dailyWorkId);

            return $this->sendResponse(NULL, 'Daily Work successfully deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Daily Work',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
