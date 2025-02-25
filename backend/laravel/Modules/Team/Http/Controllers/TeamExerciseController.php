<?php

namespace Modules\Team\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Exercise\Services\ExerciseService;
use Modules\Exercise\Services\Exercise3DService;
use Modules\Exercise\Events\Load3DExerciseEvent;
use Modules\Exercise\Http\Requests\ShowExerciseRequest;
use Modules\Exercise\Http\Requests\StoreExerciseRequest;
use Modules\Exercise\Http\Requests\UpdateExerciseRequest;
use Modules\Exercise\Http\Requests\StoreFileExerciseRequest;
use Modules\Exercise\Http\Requests\StoreData3DExerciseRequest;
use Modules\Exercise\Http\Requests\DetailData3DExerciseRequest;
use Modules\Exercise\Http\Requests\StoreThumbnail3DExerciseRequest;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;

class TeamExerciseController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var $exerciseService
     */
    protected $exerciseService;

    /**
     * @var $exercise3DService
     */
    protected $exercise3DService;

    /**
     * @var object $exerciseRepository
     */
    protected $exerciseRepository;

    /**
     * @return void
     */
    public function __construct(
        ExerciseService $exerciseService,
        Exercise3DService $exercise3DService,
        ExerciseRepositoryInterface $exerciseRepository
    ) {
        $this->exerciseService = $exerciseService;
        $this->exercise3DService = $exercise3DService;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * Display a listing of exercise by team.
     * @param $team
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/teams/exercises/teams/{team_id}",
     *  tags={"Team/Exercise"},
     *  summary="Team Exercise Index",
     *  operationId="list-team-exercises",
     *  description="Returns a list of all exercises related to a team",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/distribution_exercise_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/difficulty"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/intensity"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/user_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/duration"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List of all exercise items depending on the team sent",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListTeamExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Request $request, Team $team)
    {
        $permission = Gate::inspect('list-exercise', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $exercises = $this->exerciseService->list($request->all(), $team);

            return $this->sendResponse($exercises, 'List of team exercises');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise list', $exception->getMessage());
        }
    }

    /**
     * Stores a new exercise item into the database.
     * @param StoreExerciseRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/teams/exercises/teams/{team_id}",
     *  tags={"Team/Exercise"},
     *  summary="Team Exercise Store",
     *  operationId="store-team-exercise",
     *  description="Stores a new exercise item related to a team",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreTeamExerciseRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Information about recently stored exercise item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/StoreTeamExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(StoreExerciseRequest $request, Team $team)
    {
        $permission = Gate::inspect('store-exercise', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $exercise = $this->exerciseService->store(
                $request->except('_locale'),
                Auth::id(),
                $team,
            );

            return $this->sendResponse(
                $exercise,
                $this->translator('exercise_controller_store_response_message'),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return $this->sendError('Error by storing exercise', $exception->getMessage());
        }
    }

    /**
     * Shows exercise item details
     * @param string $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/teams/exercises/{code}",
     *  tags={"Team/Exercise"},
     *  summary="Team Exercise Show",
     *  operationId="show-team-exercises",
     *  description="Returns a single item of team exercise",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/team_id_nr"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows a single team exercise item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowTeamExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(ShowExerciseRequest $request, $code)
    {
        try {
            $exercise = $this->exerciseService->show($code);

            if ($request->team_id) {
                $permission = Gate::inspect('read-exercise', $request->team_id);

                if (!$permission->allowed()) {
                    return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
                }
            }

            return $this->sendResponse($exercise, "Exercise detail");
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving exercise', $exception->getMessage());
        }
    }

    /**
     * Updates an existent exercise item.
     * @param UpdateExerciseRequest $request
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/teams/exercises/{code}",
     *  tags={"Team/Exercise"},
     *  summary="Team Exercise Update",
     *  operationId="update-team-exercises",
     *  description="Updates a single exercise item",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateTeamExerciseRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Exercise update response status",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateExerciseRequest $request, $code)
    {
        $userId = Auth::id();

        $detailExercise = $this->exerciseRepository->findOneBy(['code' => $code]);

        if ($userId != $detailExercise->user_id) {
            $permission = Gate::inspect('update-exercise', $request->team_id);

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }
        }

        try {
            $exercise = $this->exerciseService->update(
                $request->all(),
                $code
            );

            return $this->sendResponse($exercise, $this->translator('exercise_controller_update_response_message'));
        } catch (Exception $exception) {
            return $this->sendError("Error", $exception->getMessage());
        }
    }

    /**
     * Updates an existent exercise item.
     *
     * @param UpdateExerciseRequest $request
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/teams/exercises/{code}",
     *  tags={"Team/Exercise"},
     *  summary="Team Exercise Delete",
     *  operationId="delete-team-exercises",
     *  description="Deletes a single exercise item",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Exercise delete response status",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/DeleteExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function delete($code)
    {
        $userId = Auth::id();

        try {
            $detailExercise = $this->exerciseRepository->findOneBy(['code' => $code]);

            if ($userId != $detailExercise->user_id) {
                $permission = Gate::inspect('delete-exercise', $detailExercise->team_id);

                if (!$permission->allowed()) {
                    return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
                }
            }

            $exercise = $this->exerciseService->delete($code);

            return $this->sendResponse($exercise, $this->translator('exercise_controller_delete_response_message'));
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     * path="/api/v1/teams/exercises/store-3d/{code}",
     * tags={"Team/Exercise"},
     * summary="Team Exercise Store 3D",
     * operationId="store-team-exercise3d",
     * description="Stores a new 3D exercise",
     * security={{"bearerAuth": {} }},
     * @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         ref="#/components/schemas/StoreTeamExerciseRequest"
     *     )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Information about recently stored exercise item",
     *     ref="#/components/responses/reponseSuccess"
     * ),
     * @OA\Response(
     *     response="401",
     *     ref="#/components/responses/notAuthenticated"
     * )
     *)
     */
    /**
     * Store data of 3D an exercise.
     *
     * @param StoreData3DExerciseRequest $request
     * @return Response
     */
    public function storeData3D(StoreData3DExerciseRequest $request, $code)
    {
        try {
            $exercise = $this->exercise3DService->store3D($request->content, $code);

            return $this->sendResponse($exercise, '3D Data has been stored');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing 3d data to the exercise', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/api/v1/teams/exercises/thumbnail-3d/{code}",
     * tags={"Team/Exercise"},
     * summary="Team Exercise Store thumbnail 3D",
     * operationId="store-team-thubmnail-exercise3d",
     * description="Stores a thumbnail 3D exercise",
     * security={{"bearerAuth": {} }},
     * @OA\Parameter(ref="#/components/parameters/_locale"),
     * @OA\Parameter(ref="#/components/parameters/code"),
     * @OA\RequestBody(
     *     required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreThumbnail3DExerciseRequest")
     *      )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Thumbnail 3D Data has been stored",
     *     ref="#/components/responses/reponseSuccess"
     * ),
     * @OA\Response(
     *     response="401",
     *     ref="#/components/responses/notAuthenticated"
     * )
     *)
     */
    /**
     * Store thumbnail of 3D an exercise.
     *
     * @param StoreThumbnail3DExerciseRequest $request
     * @return Response
     */
    public function storeThumbnail3D(StoreThumbnail3DExerciseRequest $request, $code)
    {
        try {
            $exercise = $this->exercise3DService->storeThumbnail3D($request->thumbnail, $code);

            return $this->sendResponse($exercise, 'Thumbnail 3D Data has been stored');
        } catch (Exception $exception) {
            return $this->sendError('Error by storing thumbnail 3d data to the exercise', $exception->getMessage());
        }
    }

    /**
     * * @OA\Get(
     *  path="/api/v1/teams/exercises/detail-3d/{code}",
     *  tags={"Team/Exercise"},
     *  summary="Detail data of 3D an exercise",
     *  operationId="show-3d-exercises",
     *  description="Returns data of 3d for an exercise",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     *  @OA\Response(
     *      response=200,
     *      description="Shows detail 3d for an exercise item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ShowTeamExerciseResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    /**
     * Detail data of 3D an exercise.
     *
     * @param DetailData3DExerciseRequest $request
     * @return Response
     */
    public function detailData3D($code)
    {
        try {
            $detail = $this->exercise3DService->show3D(
                $code
            );

            if (is_null($detail)) {
                return $this->sendError('Error exercise not found', null);
            }

            return $this->sendResponse($detail, 'Detail data 3D exercise.');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving 3d data', $exception->getMessage());
        }
    }

    /**
     * * @OA\Put(
     *  path="/api/v1/teams/exercises/status-3d/{code}",
     *  tags={"Team/Exercise"},
     *  summary="Send status close 3D an exercise",
     *  operationId="status-3d-exercises",
     *  description="Returns status close 3d for an exercise",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     * @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    /**
     * Return status close 3D an exercise.
     *
     * @param string $code
     * @return Response
     */
    public function statusExercise3D($code)
    {
        try {
            $exercise = $this->exerciseRepository->findOneBy([
                'code' => $code
            ]);

            if (is_null($exercise)) {
                return $this->sendError('Error exercise not found', null);
            }

            $status = event(new Load3DExerciseEvent($exercise, 'closed'));

            return $this->sendResponse($status, 'Status send 3D exercise.');
        } catch (Exception $exception) {
            return $this->sendError('Error send status 3d', $exception->getMessage());
        }
    }

    /**
     * Store a json 3D an exercise.
     *
     * @param StoreExerciseRequest $request
     * @return Response
     */
    public function storeFile(StoreFileExerciseRequest $request, $code)
    {
        try {
            $resource = $this->exercise3DService->storeFile(
                $request->file,
                $code
            );

            return $this->sendResponse($resource, 'Exercise file uploaded', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Download a file json 3D an exercise by code.
     * @return Response
     */
    public function downloadFile($code)
    {
        try {
            return $this->exercise3DService->downloadFile($code);
        } catch (Exception $exception) {
            return $this->sendError("Error", $exception->getMessage());
        }
    }
}
