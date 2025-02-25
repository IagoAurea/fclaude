<?php

namespace Modules\Fisiotherapy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Modules\Fisiotherapy\Services\FisiotherapyService;
use Modules\Fisiotherapy\Http\Requests\TestApplicationRequest;

class FisiotherapyController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object $fisiotherapyService
     */
    protected $fisiotherapyService;

    /**
     * Creates a new controller instance
     */
    public function __construct(FisiotherapyService $fisiotherapyService)
    {
        $this->fisiotherapyService = $fisiotherapyService;
    }

    /**
     * Retrieve all tests created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/fisiotherapy/list/user",
     *  tags={"Fisiotherapy"},
     *  summary="List all files fisiotherapy of user authenticate
     *  - Lista todos las fichas de fisioterapia creadas por el usuario",
     *  operationId="list-fisiotherapy-user",
     *  description="List all files fisiotherapy of user authenticate -
     *  Lista todos las fichas de fisioterapia creadas por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllFileFisiotherapyUser()
    {
        $files = $this->fisiotherapyService->allTestsByUser(Auth::id());

        return $this->sendResponse($files, 'List all files fisiotherapy of user');
    }


    /**
     * @OA\Get(
     *  path="/api/v1/fisiotherapy/{team_id}/players",
     *  tags={"Fisiotherapy"},
     *  summary="List player fisiotherapy information - Listado de informacion de jugadores con fisioterapia",
     *  operationId="list-fisiotherapy-team-players",
     *  description="Returns a list of players fisiotherapy information -
           Retorna listado de de jugadores con fisioterapia",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/player_name" ),
     *  @OA\Parameter( ref="#/components/parameters/start_date" ),
     *  @OA\Parameter( ref="#/components/parameters/team_staff_name" ),
     *  @OA\Parameter( ref="#/components/parameters/team_staff_id" ),
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
     * Retrieves a list of all related players to the
     * team with their fisiotherapy information
     *
     * @return Response
     */
    public function players(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-fisiotherapy', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $players = $this->fisiotherapyService->listPlayers($request->query(), $teamId);

        return $this->sendResponse($players, 'Fisiotherapy Player List');
    }

    /**
     * @OA\Post(
     *       path="/api/v1/fisiotherapy/{team_id}/players/test",
     *       tags={"Fisiotherapy"},
     *       summary="Stored/Updated Test Application - Guardar/Actualiza una Aplicación del test",
     *       operationId="test-application-store",
     *       description="Stored or Updated Test Application to file fisiotherapy -
     *       Guardar/Actualiza una Aplicación del test a una ficha de fisioterapia",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/team_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/TestApplicationRequest")
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
     * Test application to Fisiotherapy
     *
     * @return Response
     */
    public function testApplication(TestApplicationRequest $request)
    {
        $application = $this->fisiotherapyService->testApplication($request);

        return $this->sendResponse(
            $application['data'],
            $this->translator('fisiotherapy_test_controller_store_response_message')
        );
    }

    /**
     * @OA\Get(
     *  path="/api/v1/fisiotherapy/{team_id}/players/{player_id}/files/{file_id}/test",
     *  tags={"Fisiotherapy"},
     *  summary="Retrieve detail test application - Retorna detalle de aplicacion de test de fisioterapia",
     *  operationId="show-test-application-fisiotherapy",
     *  description="Retrieve detail test application - Retorna detalle de aplicacion de test de fisioterapia",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/player_id" ),
     *  @OA\Parameter( ref="#/components/parameters/file_id" ),
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
     * Show Test application to Fisiotherapy
     *
     * @return Response
     */
    public function showTestApplication($team_id, $player_id, $file_id)
    {
        $application = $this->fisiotherapyService->getDetailTestApplication($file_id, $player_id, $team_id);

        return $this->sendResponse($application, 'File test application detail');
    }
}
