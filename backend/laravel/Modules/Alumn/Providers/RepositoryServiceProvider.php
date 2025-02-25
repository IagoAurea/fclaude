<?php

namespace Modules\Alumn\Providers;

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
            'AcneaeType',
            'AcneaeSubtype',
            'Alumn',
            'AlumnSport',
            'AlumnSubject',
            'ClassroomAcademicYearAlumn',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Alumn\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Alumn\\Repositories\\{$model}Repository"
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
