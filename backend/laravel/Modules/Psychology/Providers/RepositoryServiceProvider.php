<?php


namespace Modules\Psychology\Providers;


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
            'PsychologySpecialist',
            'PsychologyReport'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Psychology\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Psychology\\Repositories\\{$model}Repository"
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
