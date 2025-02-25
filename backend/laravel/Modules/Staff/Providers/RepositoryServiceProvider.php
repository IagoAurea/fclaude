<?php

namespace Modules\Staff\Providers;

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
            'StaffUser',
            'StaffWorkExperience',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Staff\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Staff\\Repositories\\{$model}Repository"
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
