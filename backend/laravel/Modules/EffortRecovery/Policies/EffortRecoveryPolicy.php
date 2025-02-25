<?php

namespace Modules\EffortRecovery\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class EffortRecoveryPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const EFFORT_RECOVERY_STORE = 'team_effort_recovery_store';
    const EFFORT_RECOVERY_UPDATE = 'team_effort_recovery_update';
    const EFFORT_RECOVERY_DELETE = 'team_effort_recovery_delete';
    const EFFORT_RECOVERY_READ = 'team_effort_recovery_read';
    const EFFORT_RECOVERY_LIST = 'team_effort_recovery_list';

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

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EFFORT_RECOVERY_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.show.deny'));
    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EFFORT_RECOVERY_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.index.deny'));
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EFFORT_RECOVERY_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.delete.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EFFORT_RECOVERY_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EFFORT_RECOVERY_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.store.deny'));
        }

        $subscriptionEffortRecoveryQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'recovery_exertion');

        $effortsRecoveryUserQuantity = $user->effortsRecovery->count();

        return $effortsRecoveryUserQuantity < $subscriptionEffortRecoveryQuantity
            ? Response::allow()
            : Response::deny(@trans('effortrecovery::messages.policies.effort_recovery.store.deny.max_limit'));
    }
}
