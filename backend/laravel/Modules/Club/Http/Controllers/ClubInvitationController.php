<?php

namespace Modules\Club\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Club\Entities\Club;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use Modules\Staff\Services\StaffService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Club\Http\Requests\IndexClubInvitationRequest;
use Modules\Club\Services\ClubInvitationService;
use Modules\Club\Http\Requests\StoreClubInvitationRequest;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Http\Requests\UpdateInvitationPermissionsRequest;
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;

class ClubInvitationController extends BaseController
{
    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $clubInvitationRepository;

    /**
     * Instances a new controller class.
     */
    protected $userRepository;

    /**
     * Instances a new controller class.
     */
    protected $teamRepository;

    /**
     * @var object
     */
    protected $clubInvitationService;

    /**
     * @var object
     */
    protected $staffService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
        ClubInvitationRepositoryInterface $clubInvitationRepository,
        UserRepositoryInterface $userRepository,
        TeamRepositoryInterface $teamRepository,
        ClubInvitationService $clubInvitationService,
        StaffService $staffService
    ) {
        $this->clubRepository = $clubRepository;
        $this->clubInvitationRepository = $clubInvitationRepository;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->clubInvitationService = $clubInvitationService;
        $this->staffService = $staffService;
    }

    /**
     * Displays a list of current invitations depending on the
     * club sent via parameter
     *
     * @param Club $club
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/invitations",
     *  tags={"Club/Invitation"},
     *  summary="Get list Invitations by club- Lista de Invitaciones por club",
     *  operationId="list-invitations-club",
     *  description="Return data list invitations by club  - Retorna listado de Invitaciones por club",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Parameter( ref="#/components/parameters/page" ),
     *  @OA\Parameter( ref="#/components/parameters/per_page" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(IndexClubInvitationRequest $request, Club $club)
    {
        $invitations = $this->clubInvitationService->listInvitations($club, $request);
        
        return $this->sendResponse($invitations, 'Club Invitations');
    }

    /**
     * Display a listing of club staff member list.
     * @param $team
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/invitations/members-list",
     *  tags={"Club/Invitation"},
     *  summary="Club Staff Member Index",
     *  operationId="list-club-staff-invitations-users",
     *  description="Returns a list of all staff members related to a club",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/club_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="List club staff members",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListStaffResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function usersIndex(Club $club)
    {
        try {
            $staffs = $this->staffService->index($club, null, true);

            return $this->sendResponse($staffs, 'Club staff member list');
        } catch (Exception $exception) {
            return $this->sendError('Error by listing staff users', $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Retrieves the current status of the invitation, and returns the current customer status
     *
     * @param String $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/invitations/{code}/status",
     *  tags={"Club/Invitation"},
     *  summary="Show status by invitation - Ver el estado de una invitación",
     *  operationId="show-status-invitation",
     *  description="Return data to status by invitation  - Retorna el estado de una invitación ",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function status(Club $club, $code) {
        try {
            // Get the invitation depending on the code sent via URL
            $invitation = $this->clubInvitationRepository->findOneBy([
                'code'  =>  $code
            ]);

            // If invitation does not exists, return a 404 error
            if (!$invitation) {
                return $this->sendError('Error by retrieving status', 'Not found', Response::HTTP_NOT_FOUND);
            }

            $redirection = $invitation->invited_user->activeSubscriptionByType()
                || $invitation->invited_user->activeLicenses->count() > 0;

            // Build the returning data array
            $statusData = [
                'user_email'    =>  $invitation->invited_user_email,
                'user_email_verified' => $invitation->invited_user->email_verified_at ? true : false,
                'user_active' => $invitation->invited_user->is_active ? true : false,
                'subscription' => $invitation->invited_user->activeSubscriptionByType(),
                'licenses' => $invitation->invited_user->activeLicenses,
                'needs_redirection' => !$redirection,
            ];

            // Send the response
            return $this->sendResponse($statusData, 'Invitation Status');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving status', $exception->getMessage());
        }
    }

    /**
     * Retrieves the detail of the invitation, and returns the current customer status
     *
     * @param String $code
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/invitations/{code}",
     *  tags={"Club/Invitation"},
     *  summary="Show detail by invitation - Ver detalle de una invitación",
     *  operationId="show-invitation",
     *  description="Return data of invitation  - Retorna el detalle de una invitación ",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show(Club $club, $code) {
        try {
            $invitation = $this->clubInvitationRepository->findOneBy([
                'code'  =>  $code
            ]);

            if (!$invitation) {
                return $this->sendError('Error by retrieving status', 'Not found', Response::HTTP_NOT_FOUND);
            }

            $invitation->permissions = $this->clubInvitationService->listPermissions($invitation);

            return $this->sendResponse($invitation, 'Show invitation');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving invitation', $exception->getMessage());
        }
    }

    /**
     * Stores a new invitation into the database
     *
     * @param StoreClubInvitationRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/clubs/invite",
     *  tags={"Club/Invitation"},
     *  summary="Invited Users - invitar usuarios ",
     *  operationId="invited-store",
     *  description="Invited Users - Invitar usuarios",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/StoreClubInvitationRequest")
     *      )
     *  ),
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
    public function store(StoreClubInvitationRequest $request)
    {
        try {
            $this->clubInvitationService->store($request->all(), Auth::user());
            
            return $this->sendResponse(null, 'Invitations sent', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by sending the invitation', $exception->getMessage());
        }
    }

    /**
     * Update permissions associate to invitation
     *
     * @param string $code
     * @param UpdateInvitationPermissionsRequest $request
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/clubs/invitations/details/{code}",
     *  tags={"Club/Invitation"},
     *  summary="Edit permissions by inivtation - Editar permisos por inivitación",
     *  operationId="invitation-permision-edit",
     *  description="Edit a invitation permissions - Edita permisos por inivitación",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/UpdateInvitationPermissionsRequest")
     *      )
     *  ),
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
    public function updatePermissions(UpdateInvitationPermissionsRequest $request , $code)
    {
        // Get the invitation depending on the code sent via URL
        $invitations = $this->clubInvitationRepository->findBy(['code'  =>  $code]);

        if ($invitations->count() === 0) {
            return $this->sendError("Error", "Invitations not found", Response::HTTP_NOT_FOUND);
        }

        foreach ($invitations as $invitation) {
            $update =  $this->clubInvitationService->updatePermissions(
                $invitation->invited_user_id,
                $invitation->team_id,
                $request->permissions
            );
    
            if (isset($update['error']) && $update['error'] ) {
                return $this->sendError('Error by update permissions',  $update);
            }
        }

        return $this->sendResponse(null, 'Permissions update', Response::HTTP_ACCEPTED);
    }

    /**
     * Updates a new invitation into the database
     *
     * @param StoreClubInvitationRequest $request
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/clubs/invitations/update",
     *  tags={"Club/Invitation"},
     *  summary="Update Invited Users Invitations - Actualiza Invitaciones de Usuarios",
     *  operationId="invited-bulk-update",
     *  description="Update invitations already sent to users - Actualiza invitaciones enviadas a los usuarios",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/StoreClubInvitationRequest")
     *      )
     *  ),
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
    public function updateMultiplePermissions(Request $request)
    {
        try {
            $update = $this->clubInvitationService->updateMultiplePermissions($request->all(), Auth::user());
            
            return $this->sendResponse($update, 'Invitations updated');
        } catch (Exception $exception) {
            return $this->sendError('Error updating sent invitations', $exception->getMessage());
        }
    }

    /**
     * Logically removes the invitation related ONLY if the one has not been yet accepted.
     * @param Int $id
     * @return Response
     *
     * @OA\Delete(
     *  path="/api/v1/clubs/invitations/{code}",
     *  tags={"Club/Invitation"},
     *  summary="Canceled invitation - Cancela una invitación",
     *  operationId="invitation-delete",
     *  description="Canceled invitation - Cancela una invitación",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/code" ),
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
    public function destroy($code)
    {
        try {
            // Retrieve the invitation from database
            $invitations = $this->clubInvitationRepository->findBy([
                'code' => $code
            ]);

            if ($invitations->count() === 0) {
                return $this->sendError("Error", "Invitations not found", Response::HTTP_NOT_FOUND);
            }

            // Loop through every invitation related with the code
            foreach ($invitations as $invitation) {
                // Check if the invitation has been already accepted
                if (!$invitation->accepted_at) {
                    $revoke = $this->clubInvitationService->revokeAllPermissions(
                        $invitation->invited_user_id,
                        $invitation->team_id
                    );

                    if (isset($revoke['error']) && $revoke['error'] ) {
                        return $this->sendError('Error by revoking permissions',  $revoke);
                    }

                    // If not, just delete the row
                    $this->clubInvitationRepository->delete($invitation->id);
                }
            }

            return $this->sendResponse(null, 'Invitations canceled', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting club', $exception->getMessage());
        }
    }

    /**
     * Accepts or rejects a club invitation
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/invitations/{code}/handle",
     *  tags={"Club/Invitation"},
     *  summary="Handle Invitation - Procesar Invitacion",
     *  operationId="club-invitation-handle",
     *  description="Handles an user clib invitation depending on the code sent ",
     *  @OA\Parameter(
     *      ref="#/components/parameters/code"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/handle_license_action"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows result of invitation handling (accepted or rejected)",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ClubInvitationHandleResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function handle(Request $request, $code)
    {
        try {
            $accepted = $this->clubInvitationService->handle($request->action, $code);
            
            return $this->sendResponse($accepted, 'Invitation handled successfully', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage(), 'Error by accepting invitation');
        }
    }

    /**
     * Accepts or rejects a club invitation
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/invitations/users/{user_id}/history",
     *  tags={"Club/Invitation"},
     *  summary="List History of Invitations",
     *  operationId="club-invitation-user-history",
     *  description="Retrieves all the invitations sent to an specific user",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/club_id"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/user_id"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows list of invitation items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UserClubInvitationHistory"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function userInvitationsHistory(Request $request, Club $club, User $user)
    {
        try {
            $history = $this->clubInvitationService->userHistory($club, $user);
            
            return $this->sendResponse($history, 'Invitation handled successfully', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by accepting invitation', $exception->getMessage());
        }
    }
}
