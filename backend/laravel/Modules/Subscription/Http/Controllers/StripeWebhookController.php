<?php

namespace Modules\Subscription\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Auth;

// Notifications
use Modules\Subscription\Notifications\SubscriptionAccepted;

// Services
use Modules\Subscription\Services\WebhookService;

class StripeWebhookController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $webhookService
     */
    protected $webhookService;

    /**
     * Creates a new controller instance
     */
    public function __construct(WebhookService $webhookService) {
        $this->webhookService = $webhookService;
    }

    /**
     * Used for payload testing behavior
     * 
     * @param Request $request
     * @return Response
     */
    public function test(Request $request)
    {
        try {
            $user = Auth::user();

            return $user->notify(
                new SubscriptionAccepted([
                    'subscriptionName' => 'Testing Subscription',
                ])
            );
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by testing webhook behavior', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
