<?php


namespace Modules\AlumnControl\Providers;


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
            'DailyControlItem',
            'DailyControl',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\AlumnControl\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\AlumnControl\\Repositories\\{$model}Repository"
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
