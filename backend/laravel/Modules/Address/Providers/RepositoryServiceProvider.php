<?php

namespace Modules\Address\Providers;

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
            'Address',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Address\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Address\\Repositories\\{$model}Repository"
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
