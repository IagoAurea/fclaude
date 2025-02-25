<?php

namespace Modules\Team\Providers;

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
            'DistributionExercise',
            'ContentExercise',
            'TeamType',
            'TeamModality',
            'Team',
            'Exercise',
            'TypeLineup',
            'TeamStaff',
            'WorkingExperienceStaff',
            'TeamStaffRelations',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Team\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Team\\Repositories\\{$model}Repository"
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
