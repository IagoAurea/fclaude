<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class VerifySubscription
{
    const TIME_CACHE = 500;

    const ACTIVE = 'active';
    const TRIAL = 'trialing';

    const STATUS = [
        self::ACTIVE,
        self::TRIAL
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $profile = null)
    {
        $user = Auth::user();

        $subscriptionsActive = Cache::remember($user->id, self::TIME_CACHE, function () use ($user) {
            return $user->subscriptions;
        });

        if (count($subscriptionsActive) == 0) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => trans('messages.policies.club.storedeny.no_subscription')
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        if ($profile) {
            $key = sprintf('%s-%s', $user->id, $profile);

            $subscription = Cache::remember($key, self::TIME_CACHE, function () use ($user, $profile) {
                return $user->activeSubscriptionByType($profile);
            });

            if (!$subscription || !in_array($subscription->stripe_status, self::STATUS)) {
                $message = $profile == 'sport' ?
                    'no_subscription_active_sport' :
                    'no_subscription_active_teacher';

                return new JsonResponse(
                    [
                        'success' => false,
                        'message' => trans(sprintf('messages.%s', $message))
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }
        }

        return $next($request);
    }
}
