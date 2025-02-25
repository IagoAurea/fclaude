<?php

namespace Modules\Competition\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitionPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const COMPETITION_STORE = 'team_competition_store';
    const COMPETITION_UPDATE = 'team_competition_update';
    const COMPETITION_DELETE = 'team_competition_delete';
    const COMPETITION_READ = 'team_competition_read';
    const COMPETITION_LIST = 'team_competition_list';

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_READ, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition.show.deny'));
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_DELETE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition.delete.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_UPDATE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_STORE, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition.store.deny'));
    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::COMPETITION_LIST, $id);
            
        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('competition::messages.policies.competition.index.deny'));
    }
}
