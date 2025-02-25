<?php

namespace Modules\Exercise\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class ExerciseTeacherPolicy
{
    use HandlesAuthorization;

    /**
     * @var $subscriptionCache
     */
    protected $subscriptionCache;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(SubscriptionCache $subscriptionCache)
    {
        $this->subscriptionCache = $subscriptionCache;
    }

    public function store(User $user)
    {
        $subscriptionExerciseQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'exercise_design', 'teacher');

        $exercisesUserQuantity = 0;

        foreach ($user->exercises as $exercise) {
            if (count($exercise->classrooms)) {
                $exercisesUserQuantity++;
            }
        }

        return $exercisesUserQuantity < $subscriptionExerciseQuantity
            ? Response::allow()
            : Response::deny(@trans('exercise::messages.policies.exercise.store.deny.max_limit'));

    }
}
