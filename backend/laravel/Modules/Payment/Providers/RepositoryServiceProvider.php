<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'Payment',
            'Tax'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Payment\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Payment\\Repositories\\{$model}Repository"
            );
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
