<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Entities\ExerciseSession;
use Modules\Training\Services\WorkGroupService;
use Modules\Training\Http\Requests\StoreWorkGroupRequest;
use Modules\Training\Http\Requests\UpdateWorkGroupRequest;
use Modules\Training\Repositories\Interfaces\WorkGroupRepositoryInterface;

class WorkGroupController extends BaseController
{
    /**
     * @var $workGroupRepository
     */
    protected $workGroupRepository;

    /**
     * @var $workGroupService
     */
    protected $workGroupService;


    public function __construct(
        WorkGroupRepositoryInterface $workGroupRepository,
        WorkGroupService $workGroupService
    )
    {
        $this->workGroupRepository = $workGroupRepository;
        $this->workGroupService = $workGroupService;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/exercise-session/{exercise_session_id}/alumns",
    *       tags={"ExerciseSession"},
    *       summary="Get list alumns of work groups by exercise session -
    *       Lista los alumnos de grupos de trabajo por sesion de ejercicio",
    *       operationId="list-work-groups-alumns",
    *       description="Return data list alumns of work groups by exercise session  -
    *       Retorna listado de alumnos de grupos de trabajo por sesion de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
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
     * This PHP function lists the alumns in a work group for a given exercise session.
     *
     * @param ExerciseSession exercise_session The parameter `` is an instance of the
     * `ExerciseSession` class, which is being passed as an argument to the `listAlumns` method. It is
     * likely that this parameter is used within the method to retrieve a list of students or
     * participants who are enrolled in the given exercise
     *
     * @return This function is returning a response with a list of alumns (students) in a work group
     * for a given exercise session. If the function encounters an exception, it will return an error
     * message.
     */
    public function listAlumns(ExerciseSession $exercise_session)
    {
        try {
            $alumns = $this->workGroupService->listAlumns($exercise_session);

            return $this->sendResponse($alumns, 'List alumns works group');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing alumns Work Group', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/exercise-session/{exercise_session_id}/players-work-groups",
    *       tags={"ExerciseSession"},
    *       summary="Get list work groups with players by exercise session -
    *       Lista los grupos de trabajo con jugadores por sesion de ejercicio",
    *       operationId="list-work-groups-with-players",
    *       description="Return data list work groups with player by exercise session  -
    *       Retorna listado de grupos de trabajo con jugadores por sesion de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
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
     * This function lists work groups with players for a given exercise session in PHP.
     *
     * @param ExerciseSession exercise_session The parameter `` is an instance of the
     * `ExerciseSession` class, which is likely an object that represents a session of a particular
     * exercise or workout routine. It is being passed as an argument to the `listWorkGroupWithPlayers`
     * method of some class, which is expected to use
     *
     * @return This function returns a response with a list of work groups and their players, or an
     * error message if there was an exception.
     */
    public function listWorkGroupWithPlayers(ExerciseSession $exercise_session)
    {
        try {
            $workGroups = $this->workGroupService->listWorkGroupsPlayers($exercise_session);

            return $this->sendResponse($workGroups, 'List work groups with players');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing Work Group with players', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/exercise-session/{exercise_session_id}/alumns-work-groups",
    *       tags={"ExerciseSession"},
    *       summary="Get list work groups with alumns by exercise session -
    *       Lista los grupos de trabajo con alumns por sesion de ejercicio",
    *       operationId="list-work-groups-with-alumns",
    *       description="Return data list work groups with alumn by exercise session  -
    *       Retorna listado de grupos de trabajo con alumns por sesion de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
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
     * This function lists work groups with their associated students for a given exercise session.
     *
     * @param ExerciseSession exercise_session The parameter `` is an instance of the
     * `ExerciseSession` class, which is likely used to identify a specific exercise session for which
     * the work groups with their associated students are being listed. The `listWorkGroupsAlumns`
     * method of the `workGroupService` object is called
     *
     * @return This function is returning a response with a list of work groups with their
     * corresponding alumns for a given exercise session. If the function encounters an exception, it
     * will return an error message.
     */
    public function listWorkGroupWithAlumns(ExerciseSession $exercise_session)
    {
        try {
            $workGroups = $this->workGroupService->listWorkGroupsAlumns($exercise_session);

            return $this->sendResponse($workGroups, 'List work groups with alumns');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing Work Group with alumns', $exception->getMessage());
        }
    }


    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/exercise-session/{exercise_session_id}/players",
    *       tags={"ExerciseSession"},
    *       summary="Get list players of work groups by exercise session -
    *       Lista los jugadores de grupos de trabajo por sesion de ejercicio",
    *       operationId="list-work-groups-players",
    *       description="Return data list player of work groups by exercise session  -
    *       Retorna listado de jugadores de grupos de trabajo por sesion de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
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
     * This PHP function lists players in a work group session and returns a response or error message.
     *
     * @param exercise_session_id The parameter "exercise_session_id" is likely an identifier for a
     * specific exercise session in the system. It is used as input to the "listPlayers" function to
     * retrieve a list of players associated with that particular exercise session.
     *
     * @return This function is returning a response with a list of players for a given exercise
     * session ID, or an error message if there was an exception thrown.
     */
    public function listPlayers(ExerciseSession $exercise_session)
    {
        try {
            $players = $this->workGroupService->listPlayers($exercise_session);

            return $this->sendResponse($players, 'List players works group');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing players work group', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/exercise-session/{exercise_session_id}",
    *       tags={"ExerciseSession"},
    *       summary="Get list work groups by exercise session - Lista de grupos de trabajo por sesion de ejercicio",
    *       operationId="list-work-groups-team",
    *       description="Return data list work groups by exercise session  -
    *       Retorna listado de grupos de trabajo por sesion de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/exercise_session_id" ),
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
     * Display a listing of the resource.
     * @param int $team_id
     * @return Response
     */
    public function index($exercise_session_id)
    {
        $workGroups = $this->workGroupRepository->findAllWorkGroupsByExerciseSession($exercise_session_id);

        return $this->sendResponse($workGroups, 'List of Work Groups By Session exercise');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/work-groups",
    *       tags={"ExerciseSession"},
    *       summary="Stored Work Group - guardar un nuevo grupo de trabajo ",
    *       operationId="work-groups-store",
    *       description="Store a new work Group - Guarda un nuevo grupo de trabajo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreWorkGroupRequest")
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
     * Store a new Work Group.
     * @param StoreWorkGroupRequest $request
     * @return Response
     */
    public function store(StoreWorkGroupRequest $request)
    {
        try {
            $workGroupData = $this->workGroupService->createWorkGroup($request);

            return $this->sendResponse($workGroupData,
                trans('training::messages.exercise_session_work_group_store'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Work Group', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/work-groups/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show work Group - Ver los datos de un grupo de trabajo",
    *       operationId="show-work-groups",
    *       description="Return data to work Group  - Retorna los datos de un grupo de trabajo",
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
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        try {
            $workGroup = $this->workGroupRepository->findWorkGroupByCode($code);

            if (!$workGroup) {
                return $this->sendResponse($workGroup, 'Work Group not found');
            }

            return $this->sendResponse($workGroup, 'Work Group information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Work Group', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/work-groups/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Edit work Group - Editar un grupo de trabajo",
    *       operationId="work-groups-edit",
    *       description="Edit a work Group - Edita un grupo de trabajo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateWorkGroupRequest")
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
     * Update the specified resource in storage.
     * @param UpdateWorkGroupRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateWorkGroupRequest $request, $code)
    {
        try {
            $workGroup = $this->workGroupRepository->findOneBy(["code" => $code]);

            if (!$workGroup) {
                return $this->sendError("Error", "Work Group not found", Response::HTTP_NOT_FOUND);
            }

            $workGroupData = $this->workGroupService->updateWorkGroup($request, $workGroup);

            return $this->sendResponse($workGroupData,
                trans('training::messages.exercise_session_work_group_update'), Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by Updating Work Group', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/training/work-groups/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete work Group- Elimina un grupo de trabajo",
    *       operationId="work-groups-delete",
    *       description="Delete a work Group - Elimina un grupo de trabajo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
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
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     */
    public function destroy($code)
    {
        try {

            $workGroup = $this->workGroupRepository->findOneBy(["code" => $code]);

            if (!$workGroup) {
                return $this->sendError("Error", "Work Group not found", Response::HTTP_NOT_FOUND);
            }

            return $this->workGroupRepository->delete( $workGroup->id)
            ? $this->sendResponse(null, 'Work Group  deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Work Group Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Work Group ', $exception->getMessage());
        }
    }

}
