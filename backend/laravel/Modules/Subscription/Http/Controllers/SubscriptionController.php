<?php

namespace Modules\Subscription\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\StripeService;
use App\Traits\TranslationTrait;
use Modules\User\Cache\UserCache;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\Log as FacadesLog;
use Modules\Subscription\Services\LicenseService;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Notifications\SubscriptionAccepted;
use Modules\Subscription\Services\SubscriptionPaymentService;
use Modules\Subscription\Http\Requests\UpdateQuantityRequest;
use Modules\Subscription\Http\Requests\CreateSubscriptionRequest;
use Modules\Subscription\Http\Requests\UpdateSubscriptionRequest;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Subscription\Http\Requests\CancelSubscriptionRequest;
use Modules\Subscription\Http\Requests\ProrationCalulatedRequest;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionController extends BaseController
{
    const OPEN = 'open';

    use TranslationTrait;

    /**
     * @var $stripe
     */
    protected $stripe;

    /**
     * @var $subscriptionRepository
     */
    protected $subscriptionRepository;

    /**
     * @var $subscriptionService
     */
    protected $subscriptionService;

    /**
     * @var $licenseService
     */
    protected $licenseService;

    /**
     * @var @subscriptionPaymentService
     */
    protected $subscriptionPaymentService;

    /**
     * @var $packagePriceRepository
     */
    protected $packagePriceRepository;

    /**
     * @var $userCache
     */
    protected $userCache;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    public function __construct(
        StripeService $stripe,
        PackagePriceRepositoryInterface $packagePriceRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        SubscriptionService $subscriptionService,
        SubscriptionPaymentService $subscriptionPaymentService,
        LicenseService $licenseService,
        UserRepositoryInterface $userRepository,
        UserCache $userCache
    ) {
        $this->stripe = $stripe;
        $this->packagePriceRepository = $packagePriceRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionService = $subscriptionService;
        $this->subscriptionPaymentService = $subscriptionPaymentService;
        $this->licenseService = $licenseService;
        $this->userRepository = $userRepository;
        $this->userCache = $userCache;
    }

    /**
     * Update quantity of subscription
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/proration",
     *  tags={"Subscription"},
     *  summary="Calculate proration the update quantity user subscription or change subscrption -
     *  Calcula el prorrateo al actualiza la cantidad de licencias de una suscripcion o cambiar suscripcion",
     *  operationId="subscription-proration",
     *  description="Calculate proration the update quantity user subscription or change subscrption-
     *  Calcula el prorrateo al actualiza la cantidad de licencias de una suscripcion o cambiar suscripcion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ProrationCalculatedRequest"
     *      )
     *  ),
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
    public function calculateProration(ProrationCalulatedRequest $request)
    {
        $user = Auth::user();

        try {
            $proration = $this->subscriptionService->calculateProration($user, $request->validated());

            return $this->sendResponse($proration, 'Proration calculated');
        } catch (Exception $exception) {
            return $this->sendError('Error by calculated proration', $exception->getMessage());
        }
    }

    /**
     * Update quantity of subscription
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/update-quantity",
     *  tags={"Subscription"},
     *  summary="Update quantity user subscription - Actualiza la cantidad de licencias de una suscripcion",
     *  operationId="subscription-update-quantity",
     *  description="Update quantity user subscription -
     *   Actualiza la cantidad de licencias de una suscripcion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateQuantityRequest"
     *      )
     *  ),
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
    public function updateQuantitySubscription(UpdateQuantityRequest $request)
    {
        $user = Auth::user();

        try {
            $update_quantity = $this->subscriptionService->updateQuantity($user, $request->validated());

            $response = $update_quantity['response'];

            $subscription = $user->activeSubscriptionByType($request->type);

            if ($request->action == 'increment') {
                $this->licenseService->createLicenseToSubscription(
                    $subscription->id,
                    $request->quantity
                );
            } else {
                if (count($request->codes) > 0) {
                    foreach ($request->codes as $code) {
                        $this->licenseService->deleteByCode($code);
                    }
                }
            }

            return $this->sendResponse($response, $this->translator($update_quantity['key_message']));
        } catch (Exception $exception) {
            return $this->sendError('Error by update quantity subscription', $exception->getMessage());
        }
    }

    /**
     * Confirm payment of subscription
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/confirm-payment/{user_id}",
     *  tags={"Subscription"},
     *  summary="Subscription confirm payment change method -Confirma pago de una suscripcion al cambiar tarjeta",
     *  operationId="subscription-update-charge",
     *  description="Subscription confirm payment change method  -
     *  Confirma pago de una suscripcion al cambiar tarjeta",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter(
     *      ref="#/components/parameters/user_id"
     *  ),
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
    public function confirmPaymentSubscription()
    {
        try {
            $user = Auth::user();

            $invoices = $user->invoicesIncludingPending();

            $invoice_open = $invoices->first(function ($invoice) {
                return $invoice->status = self::OPEN;
            });

            if (!$invoice_open) {
                return $this->sendError('Error by invoice pendient', $this->translator('invoice_not_open'));
            }

            $payment_method_default = $user->defaultPaymentMethod();

            if (!$payment_method_default) {
                return $this->sendError(
                    'Error by default payment method',
                    $this->translator('not_default_payment_method')
                );
            }

            $this->stripe->confirmPaymentIntent($invoice_open->payment_intent, $payment_method_default->id);

            return $this->sendResponse(null, $this->translator('success_confirm_subscription'));

        } catch (Exception $exception) {
            return $this->sendError('Error by update subscription', $exception->getMessage());
        }
    }

    /**
     * Create an user subscription
     *
     * @param CreateSubscriptionRequest $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions",
     *  tags={"Subscription"},
     *  summary="Store Subscription Endpoint - Endpoint de Creacion de Subscripcion",
     *  operationId="store-subscription",
     *  description="Creates a new subscription - Crea una nueva suscripcion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CreateSubscriptionRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(CreateSubscriptionRequest $request)
    {
        $this->subscriptionService->userHasSubscription($request->user_id, $request->package_price_id);

        try {
            $user = $this->userRepository->findOneBy(['id' => $request->user_id]);

            $this->subscriptionService->userStripe($user);

            if (!$user->hasPaymentMethod()) {
                $method = $this->subscriptionService->assignMethodPayment($user, $request->payment_method_token);

                if ($method['error']) {
                    return $this->sendError($method['message'], null);
                }
                FacadesLog::debug('Method Payment assigned to user');

                $user->updateDefaultPaymentMethod($request->payment_method_token);
            }

            $plan = $this->packagePriceRepository->find($request->package_price_id);

            // Validate if current quantity is between package ranges
            if ($request->quantity < $plan->min_licenses || $request->quantity > $plan->max_licenses) {
                throw new Exception('Quantity is not between price ranges', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $paymentMethodId = $request->payment_method_token;

            $subscriptionStripe = $user->newSubscription($request->type, $plan['stripe_' . $request->interval . '_id'])
                ->quantity($request->quantity)
                ->trialDays(config('api.trial_days'))
                ->create($request->payment_method_token, [
                    'email' => $user->email,
                ], [
                    'metadata' => [
                        'user_id' => $user->id,
                        'package_price_id' => $request->package_price_id,
                    ]
                ]);

            if ($subscriptionStripe['error']) {
                return $this->sendError($subscriptionStripe['message'], null);
            }

            $this->subscriptionRepository->update([
                'interval' => $request->interval,
                'package_price_id' => $request->package_price_id,
                'amount' => $plan[$request->interval] * $request->quantity
            ], $subscriptionStripe);
            // Stores sets of licenses
            $this->licenseService->registerLicense(
                $user,
                $subscriptionStripe->id,
                $request->quantity
            );

            $this->userCache->deleteUserData($user->id);
            $user->notify(
                new SubscriptionAccepted([
                    'subscriptionName' => $plan->subpackage->name,
                ])
            );

            return $this->sendResponse(null, $this->translator('success_subscription'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by storing subscription',
                $exception->getMessage()
            );
        }
    }

    /**
     * Update subscription
     * @return Response
     *
     * @OA\Put(
     *  path="/api/v1/subscriptions",
     *  tags={"Subscription"},
     *  summary="Subscription Update Endpoint",
     *  operationId="subscription-update",
     *  description="Updates a subscription price",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/UpdateSubscriptionRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Subscription updated successfully",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SubscriptionPriceUpdateResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateSubscriptionRequest $request)
    {
        try {
            $updated = $this->subscriptionPaymentService->update(
                $request->validated(),
                Auth::user()
            );

            return $this->sendResponse($updated, 'Subscription updated');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by updating subscription',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Cancel subscription
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/cancel",
     *  tags={"Subscription"},
     *  summary="Subscription Cancel user - Cancela una suscripcion de un usuario",
     *  operationId="subscription-cancel",
     *  description="Cancel a subscription - Cancela una suscripcion de un usuario",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/CancelSubscriptionRequest"
     *      )
     *  ),
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
    public function cancel(CancelSubscriptionRequest $request)
    {
        $user = Auth::user();

        try {
            $subscription = $user->subscription($request->type);

            $cancel = $subscription->cancelNow();

            $this->subscriptionRepository->update([
                'stripe_status' => 'end',
            ], $subscription);

            return $this->sendResponse($cancel, 'Subscription canceled');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by canceling subscription',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Generate method payment test
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/method-payment",
     *  tags={"Subscription"},
     *  summary="Payment Method Creation Endpoint - Endpoint de Creacion de Metodo de Pago",
     *  operationId="payment-method-create",
     *  description="Creates a new payment method - Crea un nuevo metodo de pago",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function methodPayment()
    {
        return $this->stripe->createMethodPayment();
    }

    /**
     * Generate method payment test
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/subscriptions/create-setup-intent",
     *  tags={"Subscription"},
     *  summary="Setup intent Creation Endpoint - Endpoint de Creacion intento de pago",
     *  operationId="create-setup-intent",
     *  description="Setup intent Creation Endpoint - Endpoint de Creacion intento de pago",
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
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
    public function createSetupIntent($userId)
    {
        try {
            $user = $this->userRepository->getUser($userId);
            throw_if(!$user, 'No se encuentra usuario con el identificador proporcionado');
            $user->createOrGetStripeCustomer();
            $intent = $user->createSetupIntent();
            return $this->sendResponse($intent, 'Intento de pago creado satisfactoriamente');
        } catch (\Exception $e) {
            return $this->sendResponse(
                null,
                $e->getMessage()
            );
        }
    }
}
