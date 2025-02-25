<?php

namespace Modules\User\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Auth;

// Services
use Modules\User\Services\UserSubscriptionService;

class UserSubscriptionController extends BaseController
{
    /**
     * @var object
     */
    protected $userSubscriptionService;

    /**
     * Creates a new controller instance
     */
    public function __construct(UserSubscriptionService $userSubscriptionService) {
        $this->userSubscriptionService = $userSubscriptionService;
    }

    /**
     * Get a list of the current subscription related to the user
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/users/subscriptions",
     *  tags={"User/Subscriptions"},
     *  summary="User Suscriptions",
     *  operationId="user-get-subscription",
     *  description="Retrieve information about subscriptions related to the user",
     *  security={{"bearerAuth": {} }},
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
    public function index()
    {
        try {
            $subscriptions = $this->userSubscriptionService->index(Auth::user());
            return $this->sendResponse($subscriptions, 'User subscriptions');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving user subscriptions',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
