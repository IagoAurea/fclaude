<?php

namespace Modules\Fisiotherapy\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class FisiotherapyPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const FISIOTHERAPY_STORE = 'team_fisiotherapy_store';
    const FISIOTHERAPY_UPDATE = 'team_fisiotherapy_update';
    const FISIOTHERAPY_DELETE = 'team_fisiotherapy_delete';
    const FISIOTHERAPY_READ = 'team_fisiotherapy_read';
    const FISIOTHERAPY_LIST = 'team_fisiotherapy_list';

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * @var $subscriptionCache
     */
    protected $subscriptionCache;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        SubscriptionCache $subscriptionCache
    )
    {
        $this->userService = $userService;
        $this->subscriptionCache = $subscriptionCache;
    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::FISIOTHERAPY_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::FISIOTHERAPY_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.show.deny'));
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::FISIOTHERAPY_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.delete.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::FISIOTHERAPY_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::FISIOTHERAPY_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.store.deny'));
        }

        $subscriptionFisiotherapyQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'fisiotherapy');

        $fisiotherapyUserQuantity = $user->filesFisiotherapy->count();

        return $fisiotherapyUserQuantity < $subscriptionFisiotherapyQuantity
            ? Response::allow()
            : Response::deny(@trans('fisiotherapy::messages.policies.fisiotherapy.store.deny.max_limit'));
    }
}
