<?php

namespace Modules\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\TranslationTrait;


class SubscriptionAccepted extends Notification implements ShouldQueue
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
    public function __construct(
        $data
    ) {
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
        return (new MailMessage)
            ->greeting($this->translator('congratulations'))
            ->subject($this->translator('subscription_succeeded_subject'))
            ->line($this->translator('subscription_succeeded_line', [
                'subscriptionName' => $this->data['subscriptionName']
            ]))
            ->markdown('mail.default', [
                'footer' => $this->translator('subscription_succeeded_footer'),
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
