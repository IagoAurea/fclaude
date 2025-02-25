<?php

namespace Modules\Tutorship\Policies;


use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class TutorshipPolicy
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
        $subscriptionTutorshipQuantity = $this->subscriptionCache->quantityElementAvailable(
            $user, 'tutorials', 'teacher');

        $tutorshipsUserQuantity = $user->tutorships->count();

        return $tutorshipsUserQuantity < $subscriptionTutorshipQuantity
            ? Response::allow()
            : Response::deny(@trans('tutorship::messages.policies.tutorship.store.deny.max_limit'));
    }
}
