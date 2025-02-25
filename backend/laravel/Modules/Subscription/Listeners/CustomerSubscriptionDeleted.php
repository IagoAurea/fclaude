<?php

namespace Modules\Subscription\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class CustomerSubscriptionDeleted
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
            'stripe_status' => $stripeStatus,
            'ends_at' => date('Y-m-d H:i:s', $webhookSubscription['canceled_at'])
        ], $subscription);
    }
}
