<?php

namespace Modules\User\Cache;

use App\Cache\BaseCache;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;

class UserCache extends BaseCache
{
    /**
     * @var $userService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct('user');

        $this->userService = $userService;
    }

    public function profileUser()
    {
        $user = Auth::user();

        $key = sprintf('%s-%s', $this->key, $user->id);

        return $this->cache::remember($key, self::TTL, function () use($user) {
            return $this->userService->getProfile($user);
        });
    }

    public function deleteUserData($userId)
    {
        $key = sprintf('%s-%s', $this->key, $userId);

        return $this->cache::forget($key);
    }

}