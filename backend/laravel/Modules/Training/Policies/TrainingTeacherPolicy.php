<?php

namespace Modules\Training\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\Classroom\Entities\Classroom;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class TrainingTeacherPolicy
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
        $subscriptionExerciseQuantity = $this->subscriptionCache->quantityElementAvailable(
            $user, 'training_sessions', 'teacher');

        $sessionsUserQuantity = 0;

        foreach ($user->sessionExercises as $session) {
            if ($session->entity_type == Classroom::class) {
                $sessionsUserQuantity++;
            }
        }

        return $sessionsUserQuantity < $subscriptionExerciseQuantity
            ? Response::allow()
            : Response::deny(@trans('training::messages.policies.session_exercise.store.deny.max_limit'));
    }
}
