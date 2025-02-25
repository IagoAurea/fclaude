<?php

namespace Modules\Test\Providers;

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
            'Question',
            'QuestionCategory',
            'QuestionTest',
            'QuestionResponse',
            'Response',
            'Test',
            'TestApplication',
            'TestType',
            'TypeValoration',
            'Unit',
            'TestSubType',
            'Formula',
            'FormulaParam',
            'TestFormula',
            'Table',
            'TableDetail',
            'Configuration',
            'TestConfiguration',
            'UnitGroup'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Test\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Test\\Repositories\\{$model}Repository"
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
