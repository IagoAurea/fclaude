<?php

namespace Modules\Qualification\Providers;

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
            'Qualification',
            'QualificationItem',
            'QualificationResult',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Qualification\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Qualification\\Repositories\\{$model}Repository"
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
