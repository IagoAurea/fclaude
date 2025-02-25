<?php

namespace Modules\Club\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// Repositories
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

// External Models
use Modules\User\Entities\User;
use Modules\Team\Entities\Team;
use Modules\Club\Entities\Club;

// Events
use Modules\Activity\Events\ActivityEvent;

// Notifications
use Modules\Club\Notifications\ClubInvitationSent;

class ProcessClubInvitation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;

    /**
     * Club invitations repository handler
     *
     * @var object
     */
    protected $clubInvitationRepository;

    /**
     * User repository handler
     *
     * @var object
     */
    protected $userRepository;

    /**
     * User repository handler
     *
     * @var object
     */
    protected $teamRepository;

    /**
     * User repository handler
     *
     * @var object
     */
    protected $clubRepository;

    /**
     * Information about the sending invitation
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
        ClubInvitationRepositoryInterface $clubInvitationRepository,
        UserRepositoryInterface $userRepository,
        TeamRepositoryInterface $teamRepository,
        ClubRepositoryInterface $clubRepository,
        $invitationData
    ) {
        $this->clubInvitationRepository = $clubInvitationRepository;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->clubRepository = $clubRepository;
        $this->invitationData = $invitationData;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Check if the user exists on the database
        $invitedUser = $this->userRepository->findOneBy([
            'email' => $this->invitationData['invited_user_email']
        ]);

        // If the user does not exists, just create a new one with the email
        if (!$invitedUser) {
            $invitedUser = $this->userRepository->create([
                'email' =>  $this->invitationData['invited_user_email']
            ]);
        }

        // Make the data for insertion
        $invitationData = [
            'club_id'            =>  $this->invitationData['club_id'],
            'team_id'            =>  $this->invitationData['team_id'],
            'inviter_user_id'    =>  $this->invitationData['inviter_user_id'],
            'invited_user_id'    =>  $invitedUser->id,
            'invited_user_email' =>  $invitedUser->email,
            'code'               =>  $this->invitationData['code'],
        ];

        // Store the data into the database
        $invitation = $this->clubInvitationRepository->create($invitationData);

        // Create Permissions
        $entity = $this->teamRepository->find($this->invitationData['team_id']);

        if (!$entity)
            $entity = $this->clubRepository->find($this->invitationData['club_id']);

        if ($this->invitationData['permissions'] != "" && ($entity instanceof Team || $entity instanceof Club)) {
            $invitedUser->assignMultiplePermissions(
                $this->invitationData['permissions'],
                $entity->id,
                get_class($entity)
            );
        }

        // Search for the inviter user
        $user = $this->userRepository->findOneBy([
            'id' => $this->invitationData['inviter_user_id']
        ]);

        // Save the activity event
        event(new ActivityEvent($user, $invitation->club, 'club_invitation_sent'));
    }
}
