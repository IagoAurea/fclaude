<?php

namespace Modules\Test\Policies;

use Modules\User\Entities\User;
use Modules\Test\Entities\Test;
use Modules\Alumn\Entities\Alumn;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class TestTeacherPolicy
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
        $subscriptionTestQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'test', 'teacher');
        
        $testsUserQuantity = 0;

        foreach ($user->tests as $test) {
            if ($test->applicant_type == Alumn::class && $test->applicable_type == Test::class) {
                $testsUserQuantity++;
            }
        }

        return $testsUserQuantity < $subscriptionTestQuantity
            ? Response::allow()
            : Response::deny(@trans('test::messages.policies.test.store.deny.max_limit'));
    }
}
