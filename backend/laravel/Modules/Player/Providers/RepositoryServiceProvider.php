<?php

namespace Modules\Player\Providers;

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
            'Player',
            'LineupPlayerType',
            'PlayerContract',
            'ClubArrivalType',
            'PlayerTrajectory',
            'Skills',
            'Punctuation',
            'PlayerSkills'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Player\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Player\\Repositories\\{$model}Repository"
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
