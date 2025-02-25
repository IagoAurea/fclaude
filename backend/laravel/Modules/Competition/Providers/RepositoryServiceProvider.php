<?php


namespace Modules\Competition\Providers;


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
            'TypeCompetition',
            'TypeCompetitionSport',
            'Competition',
            'CompetitionRivalTeam',
            'CompetitionMatch',
            'CompetitionMatchLineup',
            'CompetitionMatchPlayer',
            'TestCategoryMatch',
            'TestTypeCategoryMatch',
            'CompetitionMatchRival',
            'TypeModalityMatch'
        ];

        foreach ($models as $model) {
            $this->app->bind(
                "Modules\\Competition\\Repositories\\Interfaces\\{$model}RepositoryInterface",
                "Modules\\Competition\\Repositories\\{$model}Repository"
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
