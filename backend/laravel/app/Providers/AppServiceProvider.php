<?php

namespace App\Providers;

use Laravel\Cashier\Cashier;
use Modules\User\Entities\User;
use App\Traits\TranslationTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    use TranslationTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Stripe::setApiKey(config('services.stripe.key'));
        Cashier::useCustomerModel(User::class);
        
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $verifyUrl = $this->verificationUrl($url);

            return (new MailMessage)
                ->subject($this->translator('verify_email_address'))
                /** @phpstan-ignore-line */
                ->line($this->translator('email_verification_link_duration', ['minutes' => config('api.verification.expire')]))
                ->action($this->translator('verify_email_address'), $verifyUrl);
            /** @phpstan-ignore-line */
        });

        setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");

    }

    /**
     * Get the verification URL.
     *
     * @param  string $url
     * @return string
     */
    protected function verificationUrl($url)
    {
        /** @var array $parsedUrl */
        $parsedUrl = parse_url($url);

        return config('frontend.url') . str_replace('/api/' . config('api.version'), '', $parsedUrl['path'])  . '?' . $parsedUrl['query'];
    }
}
