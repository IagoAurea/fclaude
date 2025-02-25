<?php

namespace Modules\Subscription\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Constant API user emails
     * 
     * @var array
     */
    const USER_EMAILS = [
        'user_55sy6csdmp@gmail.com',
        'cliente@fisicalcoach.com'
    ];

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $packageRepository;
    
    /**
     * @var object
     */
    protected $packagePriceRepository;
    
    /**
     * @var object
     */
    protected $subscriptionRepository;
    
    /**
     * @var object
     */
    protected $licenseRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PackageRepositoryInterface $packageRepository,
        PackagePriceRepositoryInterface $packagePriceRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        LicenseRepositoryInterface $licenseRepository
    ) {
        $this->userRepository = $userRepository;
        $this->packageRepository = $packageRepository;
        $this->packagePriceRepository = $packagePriceRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->licenseRepository = $licenseRepository;
    }

    /**
     * Stores a subscription in database depending on the type described in the
     * main testing emails
     *
     * @return void
     */
    private function appendSubscriptionByType($users, $email, $type)
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        $package = $this->packageRepository->findOneBy([
            'code' => $type
        ]);

        $randomPrice = $package->subpackages->random()->prices->random();

        $quantity = random_int(1, 3);

        $times_billing = ['year', 'month'];

        $subscriptionData = [
            'quantity' => $quantity,
            'name' => $type,
            'stripe_id' => 'stripe',
            'stripe_status' => 'active',
            'interval' => $times_billing[random_int(0, 1)],
            'user_id' =>$user->id,
            'package_price_id' => $randomPrice->id,
        ];

        $subscription = $this->subscriptionRepository->create($subscriptionData);

        if ($subscription) {
            $subscription->licenses()->create(['user_id' => $user->id]);

            for ($qty = 0; $qty < $quantity - 1; $qty++) {
                $subscription->licenses()->create([
                    'user_id' => $users->random()->id
                ]);
            }
        }
    }

    /**
     * Do the users subscriptions insertion process
     *
     * @return void
     */
    protected function createSubscriptions()
    {
        $users = $this->userRepository->findAll();

        foreach (self::USER_EMAILS as $email) {
            if (str_contains($email, 'coach')) {
                // If email string has coach type email, append only a coach subscription
                $this->appendSubscriptionByType($users, $email, 'sport');

            } elseif (str_contains($email, 'teach')) {
                // Otherwise if goes like email, just append a teach subscription
                $this->appendSubscriptionByType($users, $email, 'teacher');
            } else {
                // Common user just append both of subscription types
                $this->appendSubscriptionByType($users, $email, 'sport');
                $this->appendSubscriptionByType($users, $email, 'teacher');
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSubscriptions();
    }
}
