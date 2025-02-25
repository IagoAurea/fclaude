<?php

namespace Modules\Calculator\Providers;

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
            'CalculatorItem',
            'CalculatorItemType',
            'CalculatorEntityItemPointValue',
            'CalculatorEntityAnswerHistoricalRecord',
            'CalculatorEntityItemAnswer',
            'CalculatorEntityAnswerHistoricalRecord',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Calculator\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Calculator\\Repositories\\{$model}Repository"
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
