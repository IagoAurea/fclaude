<?php

namespace Modules\Evaluation\Policies;

use Modules\User\Entities\User;
use Modules\Alumn\Entities\Alumn;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class EvaluationPolicy
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

    public function storeRubric(User $user)
    {
        $subscriptionRubricQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'rubrics', 'teacher');

        $rubricsUserQuantity = $user->rubrics->count();

        return $rubricsUserQuantity < $subscriptionRubricQuantity
            ? Response::allow()
            : Response::deny(@trans('evaluation::messages.policies.test.evaluation_rubic.deny.max_limit'));
    }
}
