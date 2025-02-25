<?php

namespace Modules\Team\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class TeamPolicy
{
    use HandlesAuthorization;

    const TEAM = 'team';

    const TEAM_STORE = 'club_team_store';
    const TEAM_UPDATE = 'club_team_update';
    const TEAM_READ = 'club_team_read';
    const TEAM_DELETE = 'club_team_delete';

    /**
     * @var $subscriptionCache
     */
    protected $subscriptionCache;
    
    /**
     * @var $userService
     */
    protected $userService;
    
    /**
     * @var $clubRepository
     */
    protected $clubRepository;
    
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(
        SubscriptionCache $subscriptionCache,
        UserService $userService,
        ClubRepositoryInterface $clubRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->subscriptionCache = $subscriptionCache;
        $this->userService = $userService;
        $this->clubRepository = $clubRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Validate store function
     */
    public function store(User $user, $clubId)
    {
        // $hasPermission = $this->permissionService->verifyUserHasPermission($user, self::TEAM, self::TEAM_STORE, null);

        $club = $this->clubRepository->findOneBy(['id' => $clubId]);

        $owner = $user->id == $club->user_id ?
            $user :
            $this->userRepository->findOneBy(['id' => $club->user_id]);

        $subscriptionTeamQuantity = $this->subscriptionCache->quantityElementAvailable($owner, 'teams');

        $teamsClubQuantity = $club->teams->count();

        return $teamsClubQuantity < $subscriptionTeamQuantity
            ? Response::allow()
            : Response::deny(@trans('team::messages.policies.team.store.deny.max_limit'));
    }

    /**
     * Validate delete function
     */
    public function destroy(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEAM_DELETE, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('team::messages.policies.team.delete.deny'));
    }

    /**
     * Validate update function
     */
    public function update(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEAM_UPDATE, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('team::messages.policies.team.update.deny'));
    }

    /**
     * Validate show function
     */
    public function show(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEAM_READ, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('team::messages.policies.team.show.deny'));
    }

}
