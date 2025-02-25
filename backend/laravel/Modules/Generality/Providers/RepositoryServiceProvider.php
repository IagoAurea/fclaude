<?php

namespace Modules\Generality\Providers;

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
            'Country', 'Province', 'Resource', 'JobArea', 'StudyLevel', 'Kinship',
            'Season', 'Weather', 'Referee', 'WeekDay','Tax', 'Splash', 'Business',
            'TypeNotification', 'Notification'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Generality\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Generality\\Repositories\\{$model}Repository"
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
