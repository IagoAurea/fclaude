<?php

namespace Modules\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\TranslationTrait;

class LicenseCanceled extends Notification implements ShouldQueue
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
        $line = '';
        $footer = '';

        if ($this->data['destination'] == 'user') {
            $line = 'license_canceled_user_message';
            $footer = 'license_canceled_user_footer';
        } else {
            $line = 'license_canceled_owner_message';
            $footer = 'license_canceled_owner_footer';
        }

        return (new MailMessage)
            ->subject($this->translator('license_canceled_subject'))
            ->line($this->translator($line, [
                'email' => $this->data['email']
            ]))
            ->markdown('mail.default', [
                'footer' => $this->translator($footer),
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
