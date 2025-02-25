<?php

namespace Modules\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\TranslationTrait;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LicenseInvitationSent extends Notification implements ShouldQueue
{
    use Queueable, TranslationTrait;

    /**
     * @var object
     */
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $url = url(config('frontend.url') . '/subscription/licenses/' . $this->data['token']);

        return (new MailMessage)
            ->subject($this->translator('license_invitation_subject'))
            ->markdown('mail.license.invitation.sent', [
                'acceptUrl' => $url . '?action=accept',
                'rejectUrl' => $url . '?action=reject',
                'inviterUserName' => $this->data['inviter_user_name'],
                'subpackageName' => $this->data['subpackage_name'],
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
