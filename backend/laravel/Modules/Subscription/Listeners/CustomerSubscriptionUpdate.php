<?php

namespace Modules\Subscription\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Notification;
use Modules\Subscription\Notifications\SubscriptionUpdated;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;


class CustomerSubscriptionUpdate implements ShouldQueue
{
    /**
     * @var subscriptionRepostory
     */
    protected $subscriptionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(WebhookCall $webhookCall)
    {
        $webhookSubscription = $webhookCall->payload['data']['object'];
        $codeSubscription = $webhookSubscription['id'];

        $subscription = $this->subscriptionRepository->findOneBy([
            'stripe_id' => $codeSubscription
        ]);

        if (!$subscription) { return; }

        $stripeStatus = $webhookSubscription['status'];

        $this->subscriptionRepository->update([
            'stripe_status' => $stripeStatus
        ], $subscription);

        $licenses = $subscription->licenses
            ->whereNotNull('user_id')
            ->where('user_id', '!=', $subscription->user_id);

        Notification::send($subscription->user, new SubscriptionUpdated(
            ['owner' => true, 'status' => $stripeStatus]
        ));

        foreach ($licenses as $license) {
            Notification::send($license->user, new SubscriptionUpdated(
                ['owner' => false, 'status' => $stripeStatus]
            ));
        }
    }
}
