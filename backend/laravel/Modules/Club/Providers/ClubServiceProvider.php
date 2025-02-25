<?php

namespace Modules\Club\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Club\Entities\Club;
use Modules\Club\Observers\ClubObserver;
use Illuminate\Support\Facades\Gate;
use Modules\Club\Policies\ClubPolicy;

class ClubServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Club';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'club';

    /**
     * List of observer classes
     *
     * @var array $observers
     */
    protected static $observers = [
        Club::class => ClubObserver::class,
    ];

    /**
     * List of policies classes
     *
     * @var array $policies
     */
    protected static $policies = [
        'store-club' => [
            ClubPolicy::class, 'store'
        ],
        'update-club' => [
            ClubPolicy::class, 'update'
        ],
        'delete-club' => [
            ClubPolicy::class, 'destroy'
        ],
        'read-club' => [
            ClubPolicy::class, 'show'
        ],
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerObservers();
        $this->registerPolicies();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    /**
     * Manually register all model observers found in the entities
     *
     * @return void
     */
    public function registerObservers()
    {
        foreach (self::$observers as $model => $observer) {
            $model::observe($observer);
        }
    }

    /**
     * Manually register all policies definied
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach (self::$policies as $model => $policie) {
            Gate::define($model, $policie);
        }
    }
}
