<?php

namespace Modules\InjuryPrevention\Providers;

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
            'PreventiveProgramType',
            'InjuryPrevention',
            'InjuryPreventionWeekDay',
            'EvaluationQuestion',
            'InjuryPreventionEvaluationAnswer',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\InjuryPrevention\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\InjuryPrevention\\Repositories\\{$model}Repository"
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
