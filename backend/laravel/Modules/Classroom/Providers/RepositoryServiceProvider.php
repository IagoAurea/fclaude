<?php

namespace Modules\Classroom\Providers;

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
            'Teacher',
            'TeacherArea',
            'Classroom',
            'Age',
            'Subject',
            'ClassroomAcademicYear',
            'ClassroomAcademicYearRubric',
            'WorkingExperiences',
            'ClassroomSubject',
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Classroom\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Classroom\\Repositories\\{$model}Repository"
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
