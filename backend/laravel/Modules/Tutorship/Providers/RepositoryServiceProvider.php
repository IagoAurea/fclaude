<?php

namespace Modules\Tutorship\Providers;

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
            'Tutorship',
            'TutorshipType',
            'SpecialistReferral',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Tutorship\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Tutorship\\Repositories\\{$model}Repository"
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
