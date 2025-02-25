<?php

namespace Modules\Activity\Providers;

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
            'Activity', 'ActivityType', 'EntityActivity'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Activity\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Activity\\Repositories\\{$model}Repository"
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
