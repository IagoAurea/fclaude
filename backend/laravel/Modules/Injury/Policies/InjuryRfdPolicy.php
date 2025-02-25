<?php

namespace Modules\Injury\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class InjuryRfdPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const INJURY_RFD_STORE = 'team_injury_rfd_store';
    const INJURY_RFD_UPDATE = 'team_injury_rfd_update';
    const INJURY_RFD_DELETE = 'team_injury_rfd_delete';
    const INJURY_RFD_READ = 'team_injury_rfd_read';
    const INJURY_RFD_LIST = 'team_injury_rfd_list';

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
            $user, self::TEAM, self::INJURY_RFD_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injury::messages.policies.injury_rfd.index.deny'));
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_RFD_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injury::messages.policies.injury_rfd.delete.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_RFD_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injury::messages.policies.injury_rfd.show.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_RFD_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('injury::messages.policies.injury_rfd.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::INJURY_RFD_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('injury::messages.policies.injury_rfd.store.deny'));
        }

        $subscriptionInjuryRfdQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'rfd_injuries');

        $injuryRfdUserQuantity = $user->injuriesRfd->count();

        return $injuryRfdUserQuantity < $subscriptionInjuryRfdQuantity
            ? Response::allow()
            : Response::deny(@trans('injury::messages.policies.injury_rfd.store.deny.max_limit'));
    }
}
