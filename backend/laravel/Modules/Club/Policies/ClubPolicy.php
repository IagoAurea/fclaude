<?php

namespace Modules\Club\Policies;

use App\Traits\TranslationTrait;
use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Modules\User\Services\UserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Subscription\Cache\SubscriptionCache;

class ClubPolicy
{
    use HandlesAuthorization, TranslationTrait;

    const CLUB = 'club';
    const CLUB_STORE = 'club_store';
    const CLUB_UPDATE = 'club_update';
    const CLUB_DELETE = 'club_delete';
    const CLUB_READ = 'club_read';

    /**
     * @var $subscriptionCache
     */
    protected $subscriptionCache;

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(
        SubscriptionCache $subscriptionCache,
        UserService $userService
    ) {
        $this->subscriptionCache = $subscriptionCache;
        $this->userService = $userService;
    }

    public function destroy(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission($user, self::CLUB, self::CLUB_DELETE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('club::messages.policies.club.delete.deny'));
    }

    public function show(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission($user, self::CLUB, self::CLUB_READ, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('club::messages.policies.club.show.deny'));
    }


    public function update(User $user, $id)
    {
        $hasPermission = $this->userService->verifyUserHasPermission($user, self::CLUB, self::CLUB_UPDATE, $id);

        return count($hasPermission) > 0
            ? Response::allow()
            : Response::deny(@trans('club::messages.policies.club.update.deny'));
    }

    public function store(User $user)
    {
        //TODO: Descomentar si cambia la cantidad de club disponible por plan
        // $subscriptionClubQuantity = (int) $this->subscriptionCache->quantityElementAvailable($user, 'clubs');

        // $userClubsQuantity = (int) $user->clubs->count();

        // return $userClubsQuantity < $subscriptionClubQuantity
        //     ? Response::allow()
        //     : Response::deny($this->translator('policies.club.store.deny.max_limit'));

        return Response::allow();
    }
}
