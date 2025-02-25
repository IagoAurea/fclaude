<?php

namespace Modules\Subscription\Services;

use App\Services\StripeService;
use Modules\Subscription\Notifications\SubscriptionUpdated;
use Modules\Subscription\Notifications\SubscriptionInvoicePaid;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class WebhookService 
{
    /**
     * @var StripeService
     */
    protected $stripe;

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handles the Stripe event customer.subscription.updated sent from queue
     *
     * @var array $subscriptionData
     */
    public function subscriptionUpdated($subscriptionData)
    {
        $stripeStatus = $subscriptionData['status'];

        $subscription = $this->subscriptionRepository->findOneBy([
            'stripe_id' => $subscriptionData['id']
        ]);
        
        $licenses = $subscription->licenses
            ->whereNotNull('user_id')
            ->where('user_id', '!=', $subscription->user_id);

        $subscription->user->notify(
            new SubscriptionUpdated(['owner' => true, 'status' => $stripeStatus])
        );

        foreach ($licenses as $license) {
            $license->user->notify(
                new SubscriptionUpdated(['owner' => false, 'status' => $stripeStatus])
            );
        }

        return true;
    }

    /**
     *
     */
    public function testPaidNotification($subscriptionId)
    {
        $subscription = $this->subscriptionRepository->findOneBy([
            'stripe_id' => $subscriptionId
        ]);

        $licenses = $subscription->licenses
            ->whereNotNull('user_id')
            ->where('user_id', '!=', $subscription->user_id,);

        $subscription->user->notify(
            new SubscriptionInvoicePaid(['subscriptionName' => $subscription->subpackage_name, 'owner' => true])
        );

        foreach ($licenses as $license) {
            $license->user->notify(
                new SubscriptionInvoicePaid([
                    'subscriptionName' => $subscription->subpackage_name,
                    'owner' => false,
                ])
            );
        }
    }
}
