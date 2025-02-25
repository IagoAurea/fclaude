<?php

namespace Modules\Sport\Providers;

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
        $models = ['Sport', 'SportPosition', 'SportPositionSpec'];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Sport\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Sport\\Repositories\\{$model}Repository"
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
