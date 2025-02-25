<?php

namespace Modules\Subscription\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Events\ActivityEvent;
use Illuminate\Support\Facades\Notification;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Notifications\LicenseRevoked;
use Modules\Subscription\Notifications\LicenseHandled;
use Modules\Subscription\Notifications\LicenseCanceled;
use Modules\Subscription\Notifications\LicenseInvitationSent;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class LicenseService
{
    use TranslationTrait;
    /**
     * Constants for invitation statuses
     *
     * @var string
     */
    const PENDING_STATUS = 'pending';
    const REVOKED_STATUS = 'revoked';
    const EXPIRED_STATUS = 'expired';
    const ACCEPTED_STATUS = 'accepted';
    const REJECTED_STATUS = 'rejected';
    const AVAILABLE_STATUS = 'available';

    const ACTIVE = 'active';

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    /**
     * @var LicenseRepositoryInterface
     */
    protected $licenseRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        LicenseRepositoryInterface $licenseRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->licenseRepository = $licenseRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Verify license active user
     * 
     * @return boolean
     */
    public function getLicenseActiveByUser($userId)
    {
        $licenseOfUser = $this->licenseRepository->findOneBy([
            'user_id' => $userId,
            'status' => self::ACTIVE
        ]);

        return $licenseOfUser ? true : false;
    }

    /**
     * Lists all licenses related to the user subscriptions
     * @return Array
     *
     * @OA\Schema(
     *  schema="LicenseListResponse",
     *  type="object",
     *  description="Returns the list of all injury prevention related players",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of user licenses"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="user_id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *          @OA\Property(property="package_price_name", type="string", example="string"),
     *          @OA\Property(property="subpackage_name", type="string", example="string"),
     *          @OA\Property(property="package_name", type="string", example="string"),
     *          @OA\Property(property="package_code", type="string", example="string"),
     *          @OA\Property(
     *              property="licenses",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="code", type="string", example="string"),
     *                  @OA\Property(property="status", type="string", example="string"),
     *                  @OA\Property(property="subscription_id", type="int64", example="1"),
     *                  @OA\Property(property="user_id", type="int64", example="1"),
     *                  @OA\Property(property="accepted_at", type="date-time", example="2020-01-01 00:00:00"),
     *                  @OA\Property(property="expires_at", type="date-time", example="2020-01-01 00:00:00"),
     *                  @OA\Property(property="updated_at", type="date-time", example="2020-01-01 00:00:00"),
     *              )
     *          ),
     *      ),
     *  ),
     * )
     */
    public function index(Subscription | NULL $subscription)
    {
        $user = Auth::user();

        $hiddenColumns = [
            'items',
            'packagePrice',
            'stripe_id',
            'stripe_status',
            'stripe_plan',
            'quantity',
            'trial_ends_at',
            'ends_at',
            'package_price_id',
            'interval',
            'amount',
        ];

        // Map licenses through all subscriptions if none is sent
        if (!$subscription) {
            $subItems = $user->subscriptionsWithLicenses;

            foreach ($subItems as $subscriptionItem) {
                $subscriptionItem->makeHidden($hiddenColumns);

                foreach ($subscriptionItem->licenses as $license) {
                    $license->user;
                }
            }

            return $subItems;
        }

        // Otherwise just return the same subscription with all license items
        $subscription->licenses;
        $subscription->licenses->user;
        $subscription->user->id;
        $subscription->user->full_name;
        $subscription->user->email;
        $subscription->makeHidden($hiddenColumns);

        return $subscription;
    }

    /**
     * Create License
     * @param $subscription
     * @param $quantity
     * @return mixed
     */
    public function createLicenseToSubscription($subscription, $quantity)
    {
        for ($i = 1; $i <= $quantity; $i++) {
            $this->licenseRepository->create([
                'subscription_id' => $subscription
            ]);
        }

        return true;
    }

    /**
     * Register License
     * @param $user
     * @param $subscription
     * @return mixed
     */
    public function registerLicense($user, $subscription, $quantity)
    {
        $registered = $this->licenseRepository->findOneBy([
            'user_id' => $user->id,
            'subscription_id' => $subscription
        ]);

        if ($registered) {
            throw new Exception(
                'User already has an asigned licency to the subscription',
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        $this->licenseRepository->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription,
            'accepted_at' => Carbon::now()->toDateTimeString(),
            'status' => 'active',
        ]);

        // Stores rest of regitstry licenses available
        for ($i = 0; $i < $quantity - 1; $i++) {
            $this->licenseRepository->create([
                'subscription_id' => $subscription
            ]);
        }

        return true;
    }

    /**
     * Delete License by code
     * @param $code
     * @return mixed
     */
    public function deleteByCode($code)
    {
        return $this->licenseRepository->deleteByCriteria([
            'code' => $code
        ]);
    }

    /**
     *
     */
    public function deleteBySubscription($subscriptionId)
    {
        return $this->licenseRepository->deleteByCriteria([
            'subscription_id' => $subscriptionId,
        ]);
    }

    /**
     *
     */
    public function setUsersLicensesByEmails($subscriptionId, $emails = null)
    {
        if (!$emails) {
            return;
        }

        $subscription = $this->subscriptionRepository->findOneBy([
            'id' => $subscriptionId
        ]);

        $licenses = $subscription->licenses->where('status', 'available');

        for ($i = 0; $i < count($emails); $i ++) {
            $user = $this->userRepository->findOrCreate([
                'email' => strtolower($emails[$i])
            ]);

            $this->licenseRepository->update([
                'subscription_id' => $subscriptionId,
                'user_id' => $user->id,
                'accepted_at' => Carbon::now()->toDateTimeString(),
                'status' => self::ACCEPTED_STATUS,
            ], $licenses[$i + 1]);
        }
    }

    /**
     * Accepts or rejects an invitation
     * @return bool
     *
     * @OA\Schema(
     *  schema="LicenseInviteHandleResponse",
     *  type="object",
     *  description="Retrieves the result of subscription handling",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="License successfully handled"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="needs_registration", type="boolean", example="false"
     *      ),
     *      @OA\Property(
     *          property="token", type="string", example="string"
     *      ),
     *      @OA\Property(
     *          property="invite_status", type="string", example="string"
     *      ),
     *  ),
     * )
     */
    public function handle($action, $token)
    {
        $license = $this->findLicenseByToken($token);

        $currentTime = Carbon::now()->toDateTimeString();

        if (!$license->expires_at || $currentTime > $license->expires_at) {
            throw new Exception('Invitation has expired', Response::HTTP_UNAUTHORIZED);
        }

        // In case the user is not yet registered on the application
        if (!$license->user->active) {
            return [
                'needs_registration' => true,
                'token' => $license->token,
                'invite_status' => $license->status,
                'email' => $license->user->email
            ];
        }

        $status = $action == 'accept' ? self::ACCEPTED_STATUS : self::REJECTED_STATUS;

        $acceptedAt = $action == 'accept' ? Carbon::now() : null;

        $this->licenseRepository->update([
            'status' => $status,
            'accepted_at' => $acceptedAt,
            'expires_at' => null,
        ], $license);

        $license->subscription->user->notify(
            new LicenseHandled([
                'status' => $status,
                'email' => $license->user->email,
            ])
        );

        $activityCode = "license_invitation_$status";

        event(
            new ActivityEvent($license->user, $license, $activityCode, $license->subscription)
        );

        return [
            'needs_registration' => false,
            'token' => $license->token,
            'invite_status' => $status,
            'email' => $license->user->email
        ];
    }

    /**
     * TODO: Handle this process through scheduled job processes
     * Handles the invitation for a single user
     * @return bool
     *
     * @OA\Schema(
     *  schema="LicenseInviteResponse",
     *  type="object",
     *  description="Response when a single invitation is sent",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of user licenses"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true"
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="UnprocessableLicenseInviteResponse",
     *  type="object",
     *  description="Response when invitation is not available",
     *  @OA\Property(property="success", type="boolean", example="false"),
     *  @OA\Property(property="message", type="string", example="Error by sending single license invitation"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="This invitation is pending for response or is already taken"
     *  ),
     * )
     */
    public function singleInvite($requestData)
    {
        $license = $this->findLicense($requestData['code']);

        if ($license->status != 'available') {
            throw new Exception($this->translator('user_pending_response_license_assign'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userRepository->findOrCreate([
            'email' => strtolower($requestData['email'])
        ]);

        $userWithlicense = $this->licenseRepository->findOneBy([
            'user_id' => $user->id,
            'subscription_id' => $license->subscription_id
        ]);

        if($userWithlicense) {
            throw new Exception($this->translator('user_has_license_assign'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $newToken = Str::random(60);

        $this->licenseRepository->update([
            'expires_at' => Carbon::now()->addDay()->toDateTimeString(),
            'status' => self::PENDING_STATUS,
            'user_id' => $user->id,
            'token' => $newToken,
        ], $license);

        $user->notify(new LicenseInvitationSent([
            'token'  =>  $newToken,
            'inviter_user_name' => $license->subscription->user->full_name,
            'subpackage_name' => $license->subscription->subpackage_name,
        ]));

        event(
            new ActivityEvent($license->user, $license, 'license_invitation_sent', $license->subscription)
        );

        return true;
    }

    /**
     * When licensed user cancels it's owned license
     * @return boolean
     *
     * @OA\Schema(
     *  schema="LicenseCancelResponse",
     *  type="object",
     *  description="Response when a suscription is successfully canceled",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="License canceled"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true"
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="UnprocessableLicenseCancelResponse",
     *  type="object",
     *  description="Response when license has no related user",
     *  @OA\Property(property="success", type="boolean", example="false"),
     *  @OA\Property(property="message", type="string", example="Error by canceling license"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="License is not being used by any user"
     *  ),
     * )
     */
    public function cancel($code)
    {
        $license = $this->findLicense($code);

        if (!$license->user_id) {
            throw new Exception('License is not being used by any user',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($license->user_id != Auth::id()) {
            throw new Exception('License can only be canceled by its owner',
                Response::HTTP_UNAUTHORIZED);
        }

        $license->subscription->user->notify(
            new LicenseCanceled([
                'email' => $license->user->email,
                'destination' => 'owner',
            ])
        );

        $license->user->notify(
            new LicenseCanceled([
                'email' => $license->subscription->user->email,
                'destination' => 'user',
            ])
        );

        event(
            new ActivityEvent($license->user, $license, 'license_canceled', $license->subscription)
        );

        return $this->licenseRepository->update([
            'expires_at' => null,
            'accepted_at' => null,
            'status' => self::AVAILABLE_STATUS,
            'user_id' => null,
        ], $license);
    }

    /**
     * When subscription owner revokes a license from related user
     * @return boolean
     *
     * @OA\Schema(
     *  schema="LicenseRevokedResponse",
     *  type="object",
     *  description="Response when a suscription is successfully revoked",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="License revoked"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true"
     *  ),
     * )
     *
     * @OA\Schema(
     *  schema="UnprocessableLicenseRevokeResponse",
     *  type="object",
     *  description="Response when license has no related user",
     *  @OA\Property(property="success", type="boolean", example="false"),
     *  @OA\Property(property="message", type="string", example="Error by revoking license"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="License is not being used by any user"
     *  ),
     * )
     */
    public function revoke($code)
    {
        $license = $this->findLicense($code);

        if (!$license->user_id) {
            throw new Exception($this->translator('license_not_used'), Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($license->subscription->user->id != Auth::id()) {
            throw new Exception($this->translator('license_revoked_by_owner'), Response::HTTP_UNAUTHORIZED);
        }

        Notification::send($license->subscription->user, new LicenseRevoked([
            'email' => $license->user->email,
            'destination' => 'user',
        ]));

        $this->licenseRepository->update([
            'expires_at' => null,
            'accepted_at' => null,
            'status' => self::AVAILABLE_STATUS,
            'user_id' => null,
        ], $license);

        event(
            new ActivityEvent($license->user, $license, 'license_revoked', $license->subscription)
        );

        return true;
    }

    /**
     * Used to display information about a single license
     * @return boolean
     *
     * @OA\Schema(
     *  schema="LicenseShowResponse",
     *  type="object",
     *  description="Shows information about specific license",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="License data"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="code", type="string", example="string"),
     *      @OA\Property(property="status", type="string", example="string"),
     *      @OA\Property(property="subscription_id", type="int64", example="1"),
     *      @OA\Property(property="user_id", type="int64", example="1"),
     *      @OA\Property(property="accepted_at", type="date-time", example="2020-01-01 00:00:00"),
     *      @OA\Property(property="expires_at", type="date-time", example="2020-01-01 00:00:00"),
     *      @OA\Property(property="updated_at", type="date-time", example="2020-01-01 00:00:00"),
     *      @OA\Property(
     *          property="user",
     *          type="object",
     *          @OA\Property(
     *              property="id", type="int64", example="1"
     *          ),
     *          @OA\Property(
     *              property="full_name", type="string", example="string"
     *          )
     *      ),
     *      @OA\Property(
     *          property="subscription",
     *          type="object",
     *          @OA\Property(
     *              property="id", type="int64", example="1"
     *          ),
     *          @OA\Property(
     *              property="user_id", type="int64", example="1"
     *          ),
     *          @OA\Property(
     *              property="name", type="string", example="string"
     *          ),
     *          @OA\Property(
     *              property="stripe_id", type="string", example="string"
     *          ),
     *      )
     *  ),
     * )
     */
    public function show($code)
    {
        $license = $this->findLicense($code);

        $license->user;
        $license->subscription;

        return $license;
    }

    /**
     * Retrieves a list of license activities
     * @return array
     */
    public function activities($code)
    {
        $license = $this->findLicense($code);

        return $license->activities;
    }

    /**
     * Used to internally find a license
     */
    private function findLicense($code)
    {
        $license = $this->licenseRepository->findOneBy([
            'code' => $code
        ]);

        if (!$license) {
            throw new Exception('License not found', Response::HTTP_NOT_FOUND);
        }

        return $license;
    }

    /**
     *
     */
    private function findLicenseByToken($token)
    {
        $license = $this->licenseRepository->findOneBy([
            'token' => $token
        ]);

        if (!$license) {
            throw new Exception('License not found', Response::HTTP_NOT_FOUND);
        }

        return $license;
    }
}
