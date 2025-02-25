<?php

namespace Modules\Subscription\Providers;

use Modules\Subscription\Listeners\InvoicePaid;
use Modules\Subscription\Listeners\CustomerSubscriptionUpdate;
use Modules\Subscription\Listeners\CustomerSubscriptionDeleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Stripe\Customer;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'stripe-webhooks::customer.subscription.updated' => [
            CustomerSubscriptionUpdate::class,
        ],
        'stripe-webhooks::invoice.paid' => [
            InvoicePaid::class,
        ],
        'stripe-webhooks::customer.subscription.deleted' => [
            CustomerSubscriptionDeleted::class
        ]
    ];

}