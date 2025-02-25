<?php

namespace Modules\Competition\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class CompetitionMatchPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const COMPETITION_MATCH_STORE = 'team_competition_match_store';
    const COMPETITION_MATCH_UPDATE = 'team_competition_match_update';
    const COMPETITION_MATCH_DELETE = 'team_competition_match_delete';
    const COMPETITION_MATCH_READ = 'team_competition_match_read';
    const COMPETITION_MATCH_LIST = 'team_competition_match_list';

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

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_MATCH_READ, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition_match.show.deny'));
    }
   
    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_MATCH_UPDATE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition_match.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_MATCH_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('competition::messages.policies.competition_match.store.deny'));
        }

        $subscriptionMatchesQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'matches');

        $matchesUserQuantity = $this->userRepository->totalMatchesUser($user->id);

        return $matchesUserQuantity < $subscriptionMatchesQuantity
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition_match.deny.max_limit'));

    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_MATCH_LIST, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition_match.index.deny'));
    }
}
