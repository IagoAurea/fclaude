<?php

namespace Modules\Health\Providers;

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
            'Health',
            'Disease',
            'Allergy',
            'AreaBody',
            'PhysicalProblem',
            'Surgery',
            'TypeMedicine',
            'AlcoholConsumption',
            'TobaccoConsumption',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Health\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Health\\Repositories\\{$model}Repository"
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
