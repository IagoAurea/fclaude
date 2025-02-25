<?php

namespace Modules\Scouting\Providers;

use Illuminate\Support\ServiceProvider;

class ProcessorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $models = ['Results'];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Scouting\\Processors\\Interfaces\\{$model}ProcessorInterface",
                "Modules\\Scouting\\Processors\\{$model}Processor"
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
