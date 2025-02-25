<?php

namespace Modules\Psychology\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class PsychologyPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const PSYCHOLOGY_STORE = 'team_psychology_store';
    const PSYCHOLOGY_UPDATE = 'team_psychology_update';
    const PSYCHOLOGY_DELETE = 'team_psychology_delete';
    const PSYCHOLOGY_READ = 'team_psychology_read';
    const PSYCHOLOGY_LIST = 'team_psychology_list';

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

    
    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PSYCHOLOGY_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('psychology::messages.policies.psychology.delete.deny'));
    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PSYCHOLOGY_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('psychology::messages.policies.psychology.index.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PSYCHOLOGY_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('psychology::messages.policies.psychology.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PSYCHOLOGY_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('psychology::messages.policies.physology.store.deny'));
        }

        $subscriptionPsychologyQuantity = $this->subscriptionCache
            ->quantityElementAvailable($user, 'psychology_reports');

        $psychologyUserQuantity = $user->psychologies->count();

        return $psychologyUserQuantity < $subscriptionPsychologyQuantity
            ? Response::allow()
            : Response::deny(@trans('psychology::messages.policies.psychology.store.deny.max_limit'));
    }
}
