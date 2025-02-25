<?php

namespace Modules\Fisiotherapy\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Modules\Fisiotherapy\Services\FileService;
use Modules\Fisiotherapy\Http\Requests\StoreFileRequest;
use Modules\Fisiotherapy\Http\Requests\UpdateFileRequest;

class FileController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object $fileService
     */
    protected $fileService;

    /**
     * Creates a new controller instance
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @OA\Get(
     *  path="/api/v1/fisiotherapy/{team_id}/players/{file_id}",
     *  tags={"Fisiotherapy"},
     *  summary="List of all files related to a player - Lista de todos los archivos relacionados con un jugador",
     *  operationId="list-fisiotherapy-files-team-players",
     *  description="Returns a list of all files related to a player -
     *  Retorna listado de todos los archivos relacionados con un jugador",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/player_id" ),
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
    /**
     * Retrieves a list of all files related to a user
     *
     * @return Response
     */
    public function index($teamId, $playerId)
    {
        $files = $this->fileService->fileList($playerId);

        return $this->sendResponse($files, 'Player File List');
    }

    /**
     * Inserts a new file related to a player
     *
     * @return Response
     */
    public function store(StoreFileRequest $request, $teamId, $playerId)
    {
        $permission = Gate::inspect('store-fisiotherapy', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $request['user_id'] = Auth::id();

        try {
            $file =  $this->fileService->store($request->all(), $playerId);

            $fileDetail = $this->fileService->find($file->id);

            event(
                new ActivityEvent(
                    Auth::user(),
                    $fileDetail->player->team->club,
                    'fisiotherapy_file_created',
                    $fileDetail->player->team,
                )
            );

            return $this->sendResponse(
                $file,
                $this->translator('file_controller_store_response_message'),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return $this->sendError('Error by inserting file', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *  path="/api/v1/fisiotherapy/{team_id}/players/{player_id}/files/{file_id}",
     *  tags={"Fisiotherapy"},
     *  summary="Show file related to a player - Detalle de archivo relacionado con un jugador",
     *  operationId="show-fisiotherapy-files-team-players",
     *  description="Returns detail file related to a player -
     *  Retorna detalle de archivo relacionado con un jugador",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/file_id" ),
     *  @OA\Parameter( ref="#/components/parameters/player_id" ),
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
    /**
     * Retrieve specific data of a given file
     *
     * @return Response
     */
    public function show($teamId, $playerId, $fileId)
    {
        $permission = Gate::inspect('read-fisiotherapy', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $file =  $this->fileService->find($fileId);

            return $this->sendResponse($file, 'File Information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving file', $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *       path="/api/v1/fisiotherapy/{team_id}/players/{player_id}/files/{file_id}",
     *       tags={"Fisiotherapy"},
     *       summary="Updated file fisiotherapy - Actualiza una ficha de fisioterapia",
     *       operationId="update-fisiotherapy-files-team-players",
     *       description="Updated file fisiotherapy to player -
     *       Actualiza una ficha de fisioterapia a jugador",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
     *       @OA\Parameter( ref="#/components/parameters/file_id" ),
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
     * Update information about a specific file
     *
     * @return Response
     */
    public function update(UpdateFileRequest $request, $teamId, $playerId, $fileId)
    {
        $permission = Gate::inspect('update-fisiotherapy', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $file = $this->fileService->update($request->all(), $fileId);

            return $this->sendResponse($file, 'File successfully updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating file', $exception->getMessage());
        }
    }

    /**
     * Delete a role
     *
     * @return Response
     */
    public function destroy($teamId, $playerId, $fileId)
    {
        $permission = Gate::inspect('delete-fisiotherapy', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $this->fileService->destroy($fileId);

            return $this->sendResponse(null, 'File successfully deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting file', $exception->getMessage());
        }
    }
}
