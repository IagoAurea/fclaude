<?php

namespace Modules\Team\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Team\Entities\Team;
use Illuminate\Support\Facades\Gate;
use Modules\Team\Services\TeamMatchService;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;

class TeamMatchController extends BaseController
{
    /**
     * @var object
     */
    protected $teamMatchService;

    /**
     * Creates a new controller instance
     */
    public function __construct(TeamMatchService $teamMatchService)
    {
        $this->teamMatchService = $teamMatchService;
    }

    /**
     * Retrieves a list of all teams matches.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/teams/{team_id}/matches",
     *  tags={"Team/Matches"},
     *  summary="Team match list",
     *  operationId="list-team",
     *  description="Retrieves a list of all team's related matches regardless of competition",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Match list response",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/TeamMatchListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     * )
     */
    public function index(Request $request, Team $team)
    {
        $permission = Gate::inspect('list-competition-match', $team->id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $matches = $this->teamMatchService->listAllMatches($team);

            return $this->sendResponse($matches, 'Team match list');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating staff user', $exception->getMessage());
        }
    }
}
