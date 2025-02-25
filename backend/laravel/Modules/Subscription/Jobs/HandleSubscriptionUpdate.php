<?php

namespace Modules\Subscription\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;

// Services
use Modules\Subscription\Services\WebhookService;

class HandleSubscriptionUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 
     * @var \Spatie\WebhookClient\Models\WebhookCall
     */
    public $webhookCall;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall) {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(WebhookService $service)
    {
        $type = $this->webhookCall->payload['type'];

        $subscriptionData = $this->webhookCall->payload['data']['object'];

        $service->subscriptionUpdated($subscriptionData);
    }
}
