<?php

namespace Modules\Subscription\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

// Repositories
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\LicenseRepositoryInterface;

// Notifications
use Modules\Subscription\Notifications\LicenseInvitationSent;

class ProcessLicenseInvitation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Contanst for pending status
     * 
     * @var string
     */
    const PENDING_STATUS = 'pending';
    
    /**
     * Number of times the process should be repeated
     * 
     * @var int
     */
    public $tries = 3;

    /**
     * User repository handler
     * 
     * @var object
     */
    protected $userRepository;

    /**
     * License repository handler
     * 
     * @var object
     */
    protected $licenseRepository;

    /**
     * Inner items related to the invitation
     * 
     * @var array
     */
    protected $invitationData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $invitationData,
        UserRepositoryInterface $userRepository,
        LicenseRepositoryInterface $licenseRepository,
    ) {
        $this->invitationData = $invitationData;
        $this->userRepository = $userRepository;
        $this->licenseRepository = $licenseRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->invitationData['email'];

        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        if (!$user) {
            $user = $this->userRepository->create([
                'email' => $email,
            ]);
        }

        $license = $this->licenseRepository->findOneBy([
            'code' => $this->invitationData['code']
        ]);

        $this->licenseRepository->update([
            'expires_at' => Carbon::now()->addDay()->toDateTimeString(),
            'status' => self::PENDING_STATUS,
            'user_id' => $user->id,
        ], $license);

        $user->notify(new LicenseInvitationSent([
            'code'  =>  $this->invitationData['code'],
        ]));

        return true;
    }
}
