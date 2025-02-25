<?php

namespace Modules\Subscription\Services;

use Exception;
use Illuminate\Http\Response;
use App\Services\StripeService;
use App\Traits\TranslationTrait;
use Modules\Payment\Repositories\Interfaces\PaymentRepositoryInterface;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionService
{
    const ACTIVE = 'active';
    const TRIALING = 'trialing';

    use TranslationTrait;

    /**
     * @var StripeService
     */
    protected $stripe;
    
    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var PackagePriceRepositoryInterface
     */
    protected $packagePriceRepository;

        /**
     * @var LicenseRepositoryInterface
     */
    protected $licenseRepository;

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    public function __construct(
        StripeService $stripe,
        PaymentRepositoryInterface $paymentRepository,
        PackagePriceRepositoryInterface $packagePriceRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        LicenseRepositoryInterface $licenseRepository
    ) {
        $this->stripe = $stripe;
        $this->paymentRepository = $paymentRepository;
        $this->packagePriceRepository = $packagePriceRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->licenseRepository = $licenseRepository;
    }

    /**
     * Verify subscription active user
     * 
     * @return boolean
     */
    public function getSubscriptionActiveByUser($userId)
    {
        $licenseOfUser = $this->licenseRepository->findOneBy([
            'user_id' => $userId,
            'status' => self::ACTIVE
        ]);

        $subscription = $licenseOfUser->subscription;

        return $subscription->stripe_status == self::ACTIVE || $subscription->stripe_status == self::TRIALING ? true : false;
    }

      /**
     * Calculate proration subscription or license
     * @param $user
     * @param $request
     * @return array
     */
    public function calculateProration($user, $request)
    {
        $active_subscription = $user->activeSubscriptionByType($request['type']);

        if(!$active_subscription) {
            $key = 'no_subscription_active_' . $request['type'];

            throw new Exception($this->translator($key), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if($active_subscription->current_period_end_at) {

        }

        if(isset($request['license']) && count($request['license']) > 0) {

        } 

        return $active_subscription;
    }

     /**
     * Update quantity subscription user
     * @param $user
     * @param $request
     * @return array
     */
    public function updateQuantity($user, $request)
    {
        $key_message = '';

        if($request['action'] == 'increment') {
            $update = $user->subscription($request['type'])->incrementQuantity($request['quantity']);

            $key_message = $request['type'] == 'sport' ? 'subscription_increment_quantity_sport' :
                'subscription_increment_quantity_teacher';
        } else {
            $update = $user->subscription($request['type'])->decrementQuantity($request['quantity']);

            $key_message = $request['type'] == 'sport' ? 'subscription_decrement_quantity_sport' :
                'subscription_decrement_quantity_teacher';
        }

        return [
            'response' => $update,
            'key_message' => $key_message
        ];
    }

    /**
     * Create charge new subscription user
     * @param $user
     * @return boolean
     */
    public function chargeTrialUser($user, $subscription)
    {
        $paymentMethod = $user->defaultPaymentMethod();

        $description = 'Pay Trial period ' . $user->full_name;

        $charge = $this->stripe->paymentIntents([
            'customer' => $user->stripe_id,
            'description' => $description,
            'amount' => round(config('api.amount_trial')*100),
            'payment_method' => $paymentMethod->id
        ]);
        
        if($charge['error']) {
            return $charge;
        }

        $dataPayment = [
            'description' => $description,
            'code' => $charge['id'],
            'amount' => config('api.amount_trial'),
            'status' => $charge['status'],
            'user_id' => $user->id,
            'subscription_id' => $subscription
        ];

        $this->paymentRepository->create($dataPayment);
    }

     /**
     * Create or get user stripe
     * @param object
     * @return object
     */
    public function userStripe($user)
    {
        $options = [
            'description' => $user->full_name,
            'name' => $user->full_name,
            'phone' => $user->phone[0] ?? ''
        ];

        return $user->createOrGetStripeCustomer($options);
    }

    /**
     * Assign and default method payment user
     * @param $user
     * @param $method
     * @return object
     */
    public function assignMethodPayment($user, $method)
    {
        return $this->stripe->createSetupIntent([
            'payment_method' => $method,
            'customer' => $user->stripe_id,
            'usage' => 'off_session'
        ]);
    }
    /**
     * Verified user has subscription active
     * @param $user
     * @return object
     */
    public function userHasSubscription($user, $package_price)
    {
        $existSomeSubscription = $this->subscriptionRepository->findBy(['user_id' => $user, 'ends_at' => null]);

        if (count($existSomeSubscription) == 0) { return false; }

        if (count($existSomeSubscription) == 2) {
            abort(response()->error($this->translator('user_has_subscription'), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        $packagePriceNew = $this->packagePriceRepository->findOneBy(['id' => $package_price]);

        $packageNew = $packagePriceNew->subpackage->package ?? null;

        $packageSubcription = $existSomeSubscription[0]->packagePrice->subpackage->package ?? null;

        if ($packageSubcription->name === $packageNew->name) {
            abort(response()->error($this->translator('user_has_package'), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
        
        return false;
    }
}
