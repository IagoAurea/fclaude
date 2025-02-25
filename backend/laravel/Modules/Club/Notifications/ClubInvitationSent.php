<?php

namespace Modules\Club\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\TranslationTrait;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClubInvitationSent extends Notification implements ShouldQueue
{
    use Queueable, TranslationTrait;

    /**
     * @var object
     */
    protected $invitation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(config('frontend.url') . '/clubs/invitations/' . $this->invitation['code']);

        return (new MailMessage)
            ->subject($this->translator('email_club_invitation_subject'))
            ->markdown('mail.club.invitation.sent', [
                'acceptUrl' => $url . '?action=accept',
                'rejectUrl' => $url . '?action=reject',
                'clubName' => $this->invitation['club_name'],
                'annotation' => $this->invitation['annotation'],
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
