<?php

namespace Modules\User\Providers;

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
            'User',
            'Role',
            'Permission',
            'ModelPermission',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\User\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\User\\Repositories\\{$model}Repository"
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
