<?php

namespace Modules\EffortRecovery\Providers;

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
            'EffortRecovery',
            'EffortRecoveryStrategy',
            'EffortRecoveryProgramStrategy',
            'WellnessQuestionnaireAnswerType',
            'WellnessQuestionnaireAnswerItem',
            'WellnessQuestionnaireHistory',
            'WellnessQuestionnaireAnswer',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\EffortRecovery\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\EffortRecovery\\Repositories\\{$model}Repository"
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
