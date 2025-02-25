<?php

namespace Modules\Training\Providers;

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
            'ExerciseSessionAssistance',
            'ExerciseSessionPlace',
            'ExerciseSessionDetail',
            'ExerciseSession',
            'SubContentSession',
            'SubjectivePerceptionEffort',
            'TrainingPeriod',
            'TypeExerciseSession',
            'WorkGroup',
            'TargetSession',
            'ExerciseSessionLike',
            'ExerciseSessionEffortAssessment',
            'ExerciseSessionExercise',
            'ExerciseEntity',
            'TrainingLoad'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Training\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Training\\Repositories\\{$model}Repository"
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
