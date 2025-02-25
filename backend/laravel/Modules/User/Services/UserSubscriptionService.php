<?php

namespace Modules\User\Services;

use Exception;
use App\Traits\ResponseTrait;

// Repositories
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

// Entities
use Modules\User\Entities\User;

class UserSubscriptionService
{
    use ResponseTrait;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * Instance a new service class.
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves a list of all user subscriptions
     * 
     * @return array
     */
    public function index(User $user)
    {
        try {
            $subscriptions = $user->subscriptions;

            foreach ($subscriptions as $subscription) {
                $subscription->packagePrice->subpackage->makeHidden(['attributes']);
            }

            return $subscriptions;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
