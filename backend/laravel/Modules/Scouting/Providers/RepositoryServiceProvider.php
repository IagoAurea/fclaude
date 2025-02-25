<?php

namespace Modules\Scouting\Providers;

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
        $models = ['Scouting', 'ScoutingActivity', 'Action', 'ScoutingResult'];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Scouting\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Scouting\\Repositories\\{$model}Repository"
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
