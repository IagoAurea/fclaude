<?php

namespace Modules\Injury\Providers;

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
            'Injury',
            'InjuryType',
            'InjuryTypeSpec',
            'InjuryLocation',
            'InjurySituation',
            'MechanismInjury',
            'InjuryExtrinsicFactor',
            'InjuryIntrinsicFactor',
            'InjurySeverity',
            'InjuryClinicalTestType',
            'CurrentSituation',
            'DailyWork',
            'InjuryRfd',
            'Phase',
            'PhaseDetail',
            'ReinstatementCriteria',
            'ClinicalTestType',
            'InjurySeverityLocation',
            'InjuriesIntrinsicFactor',
            'InjuriesExtrinsicFactor',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Injury\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Injury\\Repositories\\{$model}Repository"
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
