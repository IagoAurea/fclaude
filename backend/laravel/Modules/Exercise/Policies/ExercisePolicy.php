<?php

namespace Modules\Exercise\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class ExercisePolicy
{
    use HandlesAuthorization;
    
    const TEAM = 'TEAM';
    const EXERCISE_STORE = 'team_exercise_store';
    const EXERCISE_UPDATE = 'team_exercise_update';
    const EXERCISE_DELETE = 'team_exercise_delete';
    const EXERCISE_READ = 'team_exercise_read';
    const EXERCISE_LIST = 'team_exercise_list';

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

    public function index(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EXERCISE_LIST, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.index.deny'));
    }

    public function destroy(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EXERCISE_DELETE, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.delete.deny'));
    }

    public function show(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EXERCISE_READ, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.show.deny'));
    }

    public function update(User $user, $teamId)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EXERCISE_UPDATE, $teamId);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.update.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::EXERCISE_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('exercise::messages.policies.exercise.store.deny'));
        }

        $subscriptionExerciseQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'exercise_design');

        $exercisesUserQuantity = 0;

        foreach ($user->exercises as $exercise) {
            if (count($exercise->teams)) {
                $exercisesUserQuantity++;
            }
        }

        return $exercisesUserQuantity < $subscriptionExerciseQuantity
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.store.deny.max_limit'));

    }
}
