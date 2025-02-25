<?php

namespace Modules\Club\Providers;

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
            'Club',
            'ClubType',
            'SchoolCenterType',
            'Staff',
            'ClubInvitation',
            'ClubUserType',
            'ClubUser',
            'WorkingExperiences',
            'PositionStaff',
            'AcademicYear',
            'AcademicPeriod',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Club\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Club\\Repositories\\{$model}Repository"
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
