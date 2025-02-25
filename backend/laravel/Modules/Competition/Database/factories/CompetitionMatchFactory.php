<?php

namespace Modules\Competition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Team\Entities\Team;

class CompetitionMatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompetitionMatch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        return [
            'competition_id' => $competition->id,
            'location' => null,
            'competition_rival_team_id' => $rival_team->id,
            'match_situation' => 'L',
            'start_at' => '3021-07-15 16:42:00',
            'referee_id' => null,
            'weather_id' => null,
        ];
    }
}
