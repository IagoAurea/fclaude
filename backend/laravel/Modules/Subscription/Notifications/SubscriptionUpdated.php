<?php

namespace Modules\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\TranslationTrait;

class SubscriptionUpdated extends Notification implements ShouldQueue
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
        $status = $this->data['status'];
        $statusString = $this->translator("subscription_$status");

        $mainMessage = $this->data['owner'] == true
            ? 'subscription_status_email_message'
            : 'subscription_license_status_email_message';

        return (new MailMessage)
            ->subject($this->translator('subscription_updated_subject'))
            ->line($this->translator($mainMessage, [
                'status' => $statusString
            ]))
            ->markdown('mail.default', [
                'footer' => $this->translator('subscription_updated_footer')
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
