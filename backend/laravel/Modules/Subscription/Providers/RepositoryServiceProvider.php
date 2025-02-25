<?php

namespace Modules\Subscription\Providers;

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
        $models = [ 'Subscription', 'License' ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Subscription\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Subscription\\Repositories\\{$model}Repository"
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
