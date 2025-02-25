<?php

namespace Modules\Subscription\Listeners;

use Carbon\Carbon;
use App\Services\StripeService;
use App\Traits\TranslationTrait;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Spatie\WebhookClient\Models\WebhookCall;
use Modules\Subscription\Notifications\SubscriptionInvoicePaid;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Payment\Repositories\Interfaces\PaymentRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class InvoicePaid
{
    use TranslationTrait;

    /**
     * @var $paymentRepository
     */
    protected $paymentRepository;

    /**
     * @var $subscriptionRepository
     */
    protected $subscriptionRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var StripeService
     */
    protected $stripe;

    /**
     * Create the payments.
     *
     * @return void
     */
    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserRepositoryInterface $userRepository,
        StripeService $stripe
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;
        $this->stripe = $stripe;
    }

    /**
     * Handle the event.
     *
     * @param  WebhookCall $webhookCall
     * @return void
     */
    public function handle(WebhookCall $webhookCall)
    {
        $webhookInvoice = $webhookCall->payload['data']['object'];

        if ($webhookInvoice['amount_paid'] == 0) { return; }

        $codeSubscription = $webhookInvoice['subscription'];

        $subscription = $this->subscriptionRepository->findOneBy([
            'stripe_id' => $codeSubscription
        ]);

        if (!$subscription) { return; }

        $description = sprintf('Suscripción del periodo desde %s del plan %s',
            $this->getDescriptionPayment($webhookInvoice['lines']), $this->translator($subscription->name));

        $this->paymentRepository->create([
            'description' => $description,
            'invoice_stripe_id' => $webhookInvoice['id'],
            'invoice_number' => $webhookInvoice['number'],
            'amount' => $webhookInvoice['total_excluding_tax'] / 100,
            'code' => $webhookInvoice['payment_intent'],
            'status' => $webhookInvoice['status'],
            'invoice_pdf_url' => $webhookInvoice['invoice_pdf'],
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'subtotal' => $webhookInvoice['subtotal_excluding_tax'] / 100,
            'tax' => $webhookInvoice['tax'] / 100
        ]);

        $licenses = $subscription->licenses
            ->whereNotNull('user_id')
            ->where('user_id', '!=', $subscription->user_id);

        $user = $this->userRepository->findOneBy(['id' => $subscription->user_id]);

        $lastPayment = $this->paymentRepository;

        $dataCompleteSubscription = $this->stripe->retrieveSubscription($codeSubscription);

        if($dataCompleteSubscription) {
            $subscription->update([
                'current_period_start_at' =>
                    Carbon::createFromTimestamp($dataCompleteSubscription['current_period_start'])->toDateTimeString(),
                'current_period_end_at' =>
                    Carbon::createFromTimestamp($dataCompleteSubscription['current_period_end'])->toDateTimeString()
            ]);
        }


        Notification::send($subscription->user,
            new SubscriptionInvoicePaid([
                'subscriptionName' => $subscription->subpackage_name,
                'owner' => true,
                'user' => $user,
                'lastPayment' => $lastPayment
            ])
        );

        foreach ($licenses as $license) {
            Notification::send($license->user,
                new SubscriptionInvoicePaid([
                    'subscriptionName' => $subscription->subpackage_name,
                    'owner' => false
                ])
            );
        }
    }

    /**
     * Get description payment.
     *
     * @param  $line
     * @return string
     */
    private function getDescriptionPayment($lines)
    {
        $periodStripe = $lines['data'][0]['period'] ?? null;
        
        $period = '';
        
        if ($periodStripe) {
            $start = Carbon::parse($periodStripe['start'])->format('d-m-y');

            $end = Carbon::parse($periodStripe['end'])->format('d-m-y');

            $period =  sprintf('%s al %s', $start, $end);
        }

        return $period;

    }
}
