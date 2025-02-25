<?php

namespace Modules\InjuryPrevention\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class InjuryPreventionPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const INJURY_PREVENTION_STORE = 'team_injury_prevention_store';
    const INJURY_PREVENTION_UPDATE = 'team_injury_prevention_update';
    const INJURY_PREVENTION_DELETE = 'team_injury_prevention_delete';
    const INJURY_PREVENTION_READ = 'team_injury_prevention_read';
    const INJURY_PREVENTION_LIST = 'team_injury_prevention_list';

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
            $user, self::TEAM, self::INJURY_PREVENTION_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_PREVENTION_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.show.deny'));
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_PREVENTION_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.delete.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_PREVENTION_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_PREVENTION_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.store.deny'));
        }

        $subscriptionInjuryPreventionQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'injury_prevention');

        $injuryPreventionUserQuantity = $user->injuriesPrevention->count();

        return $injuryPreventionUserQuantity < $subscriptionInjuryPreventionQuantity
            ? Response::allow()
            : Response::deny(@trans('injuryprevention::messages.policies.injury_prevention.store.deny.max_limit'));
    }
}
