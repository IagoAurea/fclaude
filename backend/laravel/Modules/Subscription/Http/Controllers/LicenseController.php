<?php

namespace Modules\Subscription\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Services\LicenseService;
use Modules\Subscription\Http\Requests\LicenseInviteSingleUserRequest;

class LicenseController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $licenseService
     */
    protected $licenseService;

    /**
     * Creates a new controller instance
     */
    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    /**
     * Lists an user subscription licenses
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/subscriptions/licenses",
     *  tags={"Subscription/License"},
     *  summary="User Subscription License Index",
     *  operationId="subscription-license-index",
     *  description="Retrieves a list of all user's list -
     *  Retorna un listado de las licencias de un usuario relacionadas a su suscripcion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="List of all active subscriptions related to the user with their respective licenses",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index(Subscription $subscription = null)
    {
        try {
            $licenses = $this->licenseService->index($subscription);

            return $this->sendResponse($licenses, 'List of user licenses');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving subscription licenses list',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Invites an user to join the subscription license
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/licenses/single-invite",
     *  tags={"Subscription/License"},
     *  summary="License Single Invite - Invitacion Individual de Licencia",
     *  operationId="subscription-license-single-invite",
     *  description="Invites a single user to join the subscription license -
     *  Invita a un usuario individual a unirse a una licencia de suscripcion",
     *  security={{"bearerAuth": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseInviteSingleUserRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows result of invitation sent when successfull",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseInviteResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Sent when the invitation is waiting for a response or is already taken",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UnprocessableLicenseInviteResponse"
     *      )
     *  ),
     * )
     */
    public function singleInvite(LicenseInviteSingleUserRequest $request)
    {
        try {
            $invite = $this->licenseService->singleInvite($request->validated());

            return $this->sendResponse($invite, $this->translator('license_invitation_sent'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by sending single license invitation',
                $exception->getMessage()
            );
        }
    }

    /**
     * Accepts or rejects a license invitation
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/subscriptions/licenses/{license_code}/handle",
     *  tags={"Subscription/License"},
     *  summary="Handle License - Procesar Licencia",
     *  operationId="subscription-license-handle",
     *  description="Handles an user license depending on the code sent - Acepta una licencia de usuario dependiendo del codigo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/license_code"
     *  ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/handle_license_action"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Shows result of invitation handling (accepted or rejected)",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseInviteHandleResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function handleInvite(Request $request, $token)
    {
        try {
            $handle = $this->licenseService->handle($request->action, $token);

            return $this->sendResponse($handle, 'License successfully handled!');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by accepting license invitation',
                $exception->getMessage(),
            );
        }
    }
    
    /**
     * Cancels a license in use
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/subscriptions/licenses/{license_code}/cancel",
     *  tags={"Subscription/License"},
     *  summary="Cancel License - Cancelar Licencia",
     *  operationId="subscription-license-cancel",
     *  description="Cancels a license in use",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/license_code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="License is canceled successfully",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseCancelResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Sent when license is not being used by any user",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UnprocessableLicenseCancelResponse"
     *      )
     *  ),
     * )
     */
    public function cancel($code)
    {
        try {
            $canceled = $this->licenseService->cancel($code);

            return $this->sendResponse($canceled, $this->translator('license_canceled'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by canceling license', $exception->getMessage()
            );
        }
    }

    /**
     * Revokes a license by subscription owner
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/licenses/{license_code}/revoke",
     *  tags={"Subscription/License"},
     *  summary="Revoke License - Revocar Licencia",
     *  operationId="subscription-license-revoke",
     *  description="Cancels a license in use",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/license_code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="License is revoked successfully",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseRevokedResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Sent when license is not being used by any user",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UnprocessableLicenseRevokeResponse"
     *      )
     *  ),
     * )
     */
    public function revoke($code)
    {
        try {
            $revoked = $this->licenseService->revoke($code);

            return $this->sendResponse($revoked, $this->translator('license_revoked'));
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by revoking license', $exception->getMessage()
            );
        }
    }

    /**
     * Displays information about specific license
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/subscriptions/licenses/{license_code}/show",
     *  tags={"Subscription/License"},
     *  summary="Show License - Mostrar Licencia",
     *  operationId="subscription-license-show",
     *  description="Shows information about specific license",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/license_code"
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="License is returned successfully",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/LicenseShowResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     * )
     */
    public function show($code)
    {
        try {
            $license = $this->licenseService->show($code);
            return $this->sendResponse($license, 'License data');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving license', $exception->getMessage()
            );
        }
    }

    /**
     * Retrieves all the license related activities stored in the databases.
     *
     * @param Int $id
     * @return Response Listing of the activities related
     *
     * @OA\Get(
     *  path="/api/v1/subscriptions/licenses/{license_code}/activities",
     *  tags={"Subscription/License"},
     *  summary="Get list Activities - Lista de  actividades",
     *  operationId="license-list-activities",
     *  description="Return data list activities  - Retorna listado de actividades",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="List of entity activities. IMPORTANT: entity is the license itself and secondary entity makes reference to subscription item",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ActivityListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function activities($code)
    {
        try {
            $activities = $this->licenseService->activities($code);
            
            return $this->sendResponse($activities, 'License activity list');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving license activity list', $exception->getMessage()
            );
        }
    }
}
