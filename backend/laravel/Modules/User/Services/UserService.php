<?php

namespace Modules\User\Services;

use Exception;
use Carbon\Carbon;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use Modules\Club\Entities\Club;
use Germangutierrezv\Vatlayer\Vatlayer;
use Modules\User\Cache\PermissionCache;
use Modules\Activity\Events\ActivityEvent;
use Illuminate\Support\Facades\Notification;
use Modules\User\Notifications\VatlayerError;
use Modules\Generality\Services\ResourceService;
use Modules\Subscription\Services\LicenseService;
use Modules\Subscription\Services\SubscriptionService;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;
use Modules\Staff\Repositories\Interfaces\StaffUserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserTypeRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Modules\Exercise\Entities\Exercise;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Injury\Entities\InjuryRfd;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\Player\Entities\Player;
use Modules\Scouting\Entities\Scouting;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;
use Modules\Team\Entities\Team;
use Modules\Team\Http\Controllers\TeamExerciseController;
use Modules\Test\Entities\Test;

class UserService
{
    use ResponseTrait, ResourceTrait;

    /**
     * Final class attribute to retrieve a class depending on the key
     * name given
     *
     * @var $ENTITY_CLASSES
     */
    const ENTITY_CLASSES = [
        'club' => Club::class,
        'team' => Team::class,
        'competition' => Competition::class,
        'competition_match' => CompetitionMatch::class,
        'scouting' => Scouting::class,
        'player' => Player::class,
        'exercise' => Exercise::class,
        'test' => Test::class,
        'injury_prevention' => InjuryPrevention::class,
        'injury_rfd' => InjuryRfd::class,
        'effort_recovery' => EffortRecovery::class,
    ];

    /**
     * @var $clubInvitationRepository
     */
    protected $clubInvitationRepository;

    /**
     * @var $clubUserRepository
     */
    protected $clubUserRepository;

    /**
     * @var $clubUserTypeRepository
     */
    protected $clubUserTypeRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $licenseRepository
     */
    protected $licenseRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $staffUserRepository
     */
    protected $staffUserRepository;

    /**
     * @var $subscriptionService
     */
    protected $subscriptionService;

    /**
     * @var $licenseService
     */
    protected $licenseService;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $vatlayer
     */
    protected $vatlayer;

    /**
     * @var $permissionCache
     */
    protected $permissionCache;

    /**
     * Instance a new service class.
     */
    public function __construct(
        ClubInvitationRepositoryInterface $clubInvitationRepository,
        ClubUserRepositoryInterface $clubUserRepository,
        ClubUserTypeRepositoryInterface $clubUserTypeRepository,
        UserRepositoryInterface $userRepository,
        LicenseRepositoryInterface $licenseRepository,
        ResourceRepositoryInterface $resourceRepository,
        StaffUserRepositoryInterface $staffUserRepository,
        SubscriptionService $subscriptionService,
        LicenseService $licenseService,
        ResourceService $resourceService,
        PermissionCache $permissionCache
    ) {
        $this->clubInvitationRepository = $clubInvitationRepository;
        $this->clubUserRepository = $clubUserRepository;
        $this->clubUserTypeRepository = $clubUserTypeRepository;
        $this->userRepository = $userRepository;
        $this->licenseRepository = $licenseRepository;
        $this->resourceRepository = $resourceRepository;
        $this->staffUserRepository = $staffUserRepository;
        $this->subscriptionService = $subscriptionService;
        $this->licenseService = $licenseService;
        $this->resourceService = $resourceService;
        $this->vatlayer = new Vatlayer();
        $this->permissionCache = $permissionCache;
    }

    public function update($user_id, $request)
    {
        $user = $this->userRepository->findOneBy(['id' => $user_id]);

        $resources = ['image', 'cover'];

        $dataUser = $request->except($resources);

        $deleteResources = [];

        foreach ($resources as $elm) {
            $element = $elm . '_id';

            if (!$request[$elm]) {
                continue;
            }

            $dataResource = $this->uploadResource('/users', $request[$elm]);

            if ($user[$element]) {
                array_push($deleteResources, $user[$element]);
            }

            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $dataUser[$elm . '_id'] = $resource->id;
            }
        }

        $update = $this->userRepository->update($dataUser, $user);

        foreach ($deleteResources as $del) {
            $this->resourceService->deleteResourceData($del);
        }

        $dataUserStaff = $request->only(['full_name', 'username']);

        if (isset($dataUser['image_id'])) {
            $dataUserStaff['image_id'] = $dataUser['image_id'];
        }

        $this->staffUserRepository->update($dataUserStaff, ['user_id' => $user_id], true);

        return $update;
    }

    /**
     * Get profile user
     *
     * @param $user
     */
    public function getProfile($user)
    {
        $user->image;
        $user->tax;
        $user->cover;
        $user->roles;
        $user->subscriptions;
        // $user->is_license_active = $this->licenseService->getLicenseActiveByUser($user->id);
        // $user->is_subscription_active = $this->subscriptionService->getSubscriptionActiveByUser($user->id);

        foreach ($user->subscriptions as $subscription) {
            $subscription->packagePrice->subpackage->makeHidden(['attributes']);
        }

        $permissions = [];

        foreach ($user->entityPermissions as $permission) {
            $entity_id = $permission['pivot']['entity_id'];

            $key = array_search($entity_id, array_column($permissions, 'entity_id'));

            if (is_int($key)) {
                $permissions[$key]['lists'][] = $permission['name'];
            } else {
                array_push($permissions, [
                    'entity_id' => $entity_id,
                    'entity' => $permission['entity_code'],
                    'lists' => [
                        $permission['name']
                    ]
                ]);
            }
        }

        $user->permissions = $permissions;

        $user->makeHidden(['vat_verified_at']);

        return $user;
    }

    /**
     * Verify if user has permission
     *
     */
    public function verifyUserHasPermission($user, $entity, $typePermission, $id)
    {
        $permissions = $this->permissionCache->listUserPermissions($user->id, $id, $entity);

        return array_filter($permissions, function ($element) use ($typePermission) {
            $validate = collect($element['permissions'])->filter(function ($value) use ($typePermission) {
                return $value->name === $typePermission;
            });

            return count($validate) > 0 ? $validate : [];
        });
    }

    /**
     * Generate token access
     * @param object $user
     * @return array
     */
    public function createToken($user, $remember = false)
    {
        $tokenUser = $user->generateToken($remember);

        return [
            'token' => $tokenUser->accessToken,
            'expires' => $tokenUser->token->expires_at
        ];

    }

    /**
     * Determine type login email/username
     *
     * @param string
     * @return string
     */
    public function typeLogin($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Verify if user is active
     */
    public function verifyIfUseActive($type_login, $login_data)
    {
        $existentUser = $this->userRepository->findOneBy([
            $type_login => $login_data
        ]);

        return $existentUser->active ?? false;
    }

    /**
     * Resolve a class name depending on the string sent
     *
     * @return String Name of the class related string
     */
    public function resolvePermissionClass($class)
    {
        return self::ENTITY_CLASSES[$class];
    }

    /**
     * Updates the user data and inserts their information in the club_user relational
     * table when the code is sent by a register
     *
     * @param Request $request
     * @param User A fresh created or updated user
     */
    public function handleInvitedUserRegistry($request)
    {
        try {
            $existentUser = $this->userRepository->findOneBy([
                'email' => $request->email
            ]);

            $userData = $request->except('club_invite_token');

            if (!$existentUser) {
                $existentUser = $this->userRepository->create($userData);
            } else {
                $this->userRepository->update($userData, $existentUser);

                $existentUser = $this->userRepository->findOneBy([
                    'email' => $request->email
                ]);
            }

            $this->insertClubRelation($existentUser, $request->club_invite_token);

            return $existentUser;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Updates the club_users relational table when the code is sent by a login
     *
     * @param Request $request
     * @param User A fresh created or updated user
     */
    public function handleInvitationUserLogin($request)
    {
        try {
            // Find the user depending the email sent
            $user = $this->userRepository->findOneBy([
                'email' => $request->login
            ]);

            // Insert a club relationship in the table
            $this->insertClubRelation($user, $request->club_invite_token);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Insert a relationship on the club_users table
     *
     * @param User $user object
     * @param String $tokenCode an invitation sent code
     *
     * @return void
     */
    private function insertClubRelation($user, $tokenCode)
    {
        try {
            $clubInvite = $this->clubInvitationRepository->findOneBy([
                'code' => $tokenCode
            ]);

            // Update the invitation
            $this->clubInvitationRepository->update([
                'accepted_at' => Carbon::now()
            ], $clubInvite);

            // Get the member club user type
            $clubUserType = $this->clubUserTypeRepository->findOneBy([
                'name' => 'member'
            ]);

            // Set the new club user relationship
            $this->clubUserRepository->create([
                'club_id' => $clubInvite->club_id,
                'user_id' => $user->id,
                'club_user_type_id' => $clubUserType->id
            ]);

            // Set the event of the invitation accepted
            event(new ActivityEvent($user, $clubInvite->club, 'club_invitation_accepted'));
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Handles an license invited user registry
     *
     * @return mixed
     */
    public function handleLicenseInvitationRegistry($requestData)
    {
        $license = $this->licenseRepository->findOneBy([
            'token' => $requestData['license_invite_token']
        ]);

        if (!$license) {
            throw new Exception('License token does not exists', Response::HTTP_NOT_FOUND);
        }

        $currentTime = Carbon::now()->toDateTimeString();

        if ($currentTime > $license->expires_at) {
            throw new Exception('Expiration time has passed for license invitation', Response::HTTP_UNAUTHORIZED);
        }

        if ($license->user->email != $requestData['email']) {
            throw new Exception('The email sent in the registry does not coincide with the invited one', Response::HTTP_UNAUTHORIZED);
        }

        $requestData['active'] = true;
        $requestData['email_verified_at'] = now();

        $this->userRepository->update($requestData, $license->user);

        $this->licenseRepository->update([
            'status' => 'accepted',
            'accepted_at' => $currentTime,
            'expires_at' => null,
        ], $license);

        return $license->user;
    }

    public function validateVat($user)
    {
        try {
            return $this->vatlayer->isValidVatNumber($user->company_vat);
        } catch (Exception $exception) {
            \Log::info($exception->getMessage());

            Notification::route('mail', config('setting.email_notification'))
                ->notify(new VatlayerError());

            return false;
        }
    }
}
