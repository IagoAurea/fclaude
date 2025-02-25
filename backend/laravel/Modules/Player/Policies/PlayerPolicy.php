<?php

namespace Modules\Player\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class PlayerPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const PLAYER_STORE = 'team_players_store';
    const PLAYER_UPDATE = 'team_players_update';
    const PLAYER_DELETE = 'team_players_delete';
    const PLAYER_READ = 'team_players_read';
    const PLAYER_LIST = 'team_players_list';

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * @var $userRepository
     */
    protected $userRepository;
    
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
        UserRepositoryInterface $userRepository,
        SubscriptionCache $subscriptionCache
    )
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->subscriptionCache = $subscriptionCache;
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PLAYER_DELETE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('player::messages.policies.player.delete.deny'));
    }
    
    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PLAYER_LIST, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('player::messages.policies.player.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PLAYER_READ, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('player::messages.policies.player.show.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PLAYER_UPDATE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('player::messages.policies.player.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::PLAYER_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('player::messages.policies.player.store.deny'));
        }

        $subscriptionPlayersQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'players');

        $playersUserQuantity = $this->userRepository->totalPlayersUser($user->id);

        return $playersUserQuantity < $subscriptionPlayersQuantity
            ? Response::allow()
            : Response::deny(@trans('player::messages.policies.player.store.deny.max_limit'));
    }
}
