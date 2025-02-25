<?php

namespace Modules\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Traits\TranslationTrait;

class SubscriptionInvoicePaid extends Notification implements ShouldQueue
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
        $line = $this->data['owner']
            ? 'subscription_invoice_paid_owner_line'
            : 'subscription_invoice_paid_licenser_line';

        if ($this->data['owner']) {
            $lastPayment = $this->data['lastPayment']->findOneBy(['user_id' => $this->data['user']->id]);

            $user = $this->data['user'];

            // Instance the PDF dependency
            $dompdf = App::make('dompdf.wrapper');

            // Build the PDF data
            $pdf = $dompdf->loadView('subscription_invoice', compact('lastPayment', 'user'));

            return (new MailMessage)
                ->subject($this->translator('subscription_invoice_paid_subject'))
                ->line($this->translator($line, [
                    'subscriptionName' => $this->data['subscriptionName']
                ]))
                ->markdown('mail.default', [
                    'footer' => $this->translator(''),
                ])->attachData(
                    $pdf->output(),
                    'invoice.pdf',
                    [
                        'mime' => 'application/pdf',
                    ]
                );
        } else {
            return (new MailMessage)
                ->subject($this->translator('subscription_invoice_paid_subject'))
                ->line($this->translator($line, [
                    'subscriptionName' => $this->data['subscriptionName']
                ]))
                ->markdown('mail.default', [
                    'footer' => $this->translator(''),
                ]);
        }
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
