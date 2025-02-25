<?php

namespace Modules\Fisiotherapy\Providers;

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
            'File',
            'Treatment',
            'DailyWork'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Fisiotherapy\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Fisiotherapy\\Repositories\\{$model}Repository"
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
