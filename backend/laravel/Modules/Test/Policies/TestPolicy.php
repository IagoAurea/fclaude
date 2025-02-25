<?php

namespace Modules\Test\Policies;

use Modules\User\Entities\User;
use Modules\Test\Entities\Test;
use Modules\Player\Entities\Player;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class TestPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const TEST_STORE = 'team_test_store';
    const TEST_UPDATE = 'team_test_update';
    const TEST_DELETE = 'team_test_delete';
    const TEST_READ = 'team_test_read';
    const TEST_LIST = 'team_test_list';

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

    public function index(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEST_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('test::messages.policies.test.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEST_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('test::messages.policies.test.show.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::TEST_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('test::messages.policies.test.store.deny'));
        }

        $subscriptionTestQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'test');

        $testsUserQuantity = 0;

        foreach ($user->tests as $test) {
            if ($test->applicant_type == Player::class && $test->applicable_type == Test::class) {
                $testsUserQuantity++;
            }
        }

        return $testsUserQuantity < $subscriptionTestQuantity
            ? Response::allow()
            : Response::deny(@trans('test::messages.policies.test.store.deny.max_limit'));
    }
}
