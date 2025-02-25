<?php

namespace Modules\Nutrition\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class NutritionPolicy
{
    use HandlesAuthorization;

    const TEAM = 'TEAM';
    const NUTRITION_STORE = 'team_nutrition_store';
    const NUTRITION_UPDATE = 'team_nutrition_update';
    const NUTRITION_DELETE = 'team_nutrition_delete';
    const NUTRITION_READ = 'team_nutrition_read';
    const NUTRITION_LIST = 'team_nutrition_list';

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
            $user, self::TEAM, self::NUTRITION_LIST, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('nutrition::messages.policies.nutrition.index.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::NUTRITION_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('nutrition::messages.policies.nutrition.show.deny'));
    }

    public function store(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission(
            $user, self::TEAM, self::NUTRITION_STORE, $id);
        
        if (count($hasPermission) == 0) {
            return Response::deny(@trans('nutrition::messages.policies.nutrition.store.deny'));
        }

        $subscriptionNutritionQuantity = $this->subscriptionCache->quantityElementAvailable($user, 'nutrition');

        $nutritionSheetUserQuantity = $user->nutritionSheets->count();

        return $nutritionSheetUserQuantity < $subscriptionNutritionQuantity
            ? Response::allow()
            : Response::deny(@trans('nutrition::messages.policies.nutrition.store.deny.max_limit'));
    }
}
