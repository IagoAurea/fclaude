<?php

namespace Modules\Package\Providers;

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
        $models = [ 'Package', 'Subpackage', 'AttributePack', 'AttributesSubpackage', 'PackagePrice', 'SubpackageSport'];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Package\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Package\\Repositories\\{$model}Repository"
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
