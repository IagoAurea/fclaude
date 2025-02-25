<?php

namespace Modules\Training\Policies;

use Modules\User\Entities\User;
use Modules\Team\Entities\Team;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class TrainingPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const SESSION_EXERCISE_STORE = 'team_session_exercise_store';
    const SESSION_EXERCISE_UPDATE = 'team_session_exercise_update';
    const SESSION_EXERCISE_DELETE = 'team_session_exercise_delete';
    const SESSION_EXERCISE_READ = 'team_session_exercise_read';
    const SESSION_EXERCISE_LIST = 'team_session_exercise_list';

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
            $user, self::TEAM, self::SESSION_EXERCISE_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.delete.deny'));
    }

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::SESSION_EXERCISE_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::SESSION_EXERCISE_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.show.deny'));
    }

    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::SESSION_EXERCISE_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::SESSION_EXERCISE_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('training::messages.policies.session_exercise.store.deny'));
        }

        $subscriptionExerciseQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'training_sessions');

        $sessionsUserQuantity = 0;

        foreach ($user->sessionExercises as $session) {
            if ($session->entity_type == Team::class) {
                $sessionsUserQuantity++;
            }
        }

        return $sessionsUserQuantity < $subscriptionExerciseQuantity
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.store.deny.max_limit'));
    }
}
