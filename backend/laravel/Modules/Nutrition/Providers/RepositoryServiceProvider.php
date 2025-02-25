<?php

namespace Modules\Nutrition\Providers;

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
            'Diet',
            'Supplement',
            'NutritionalSheet',
            'WeightControl',
            "AthleteActivity",
            "Nutrition"
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Nutrition\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Nutrition\\Repositories\\{$model}Repository"
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
