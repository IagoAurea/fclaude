<?php

namespace Modules\Evaluation\Providers;

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
            'Competence',
            'Indicator',
            'Rubric',
            'EvaluationGrade',
            'EvaluationResult',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Evaluation\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Evaluation\\Repositories\\{$model}Repository"
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
