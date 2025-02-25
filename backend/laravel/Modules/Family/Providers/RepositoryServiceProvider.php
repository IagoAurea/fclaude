<?php

namespace Modules\Family\Providers;

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
            'Family',
            'FamilyMember',
            'FamilyMemberType',
            'FamilyEntityMember',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Family\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Family\\Repositories\\{$model}Repository"
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
