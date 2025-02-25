<?php

namespace Modules\Exercise\Providers;

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
            'DistributionExercise',
            'ContentExercise',
            'Exercise',
            'ExerciseContentRelation',
            'ExerciseContentBlock',
            'ExerciseContentBlockRelation',
            'ExerciseEducationLevel',
            'ExerciseTargetSession',
            'ExerciseEntity',
            'LikeEntity'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Exercise\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Exercise\\Repositories\\{$model}Repository"
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
