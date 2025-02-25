<?php

namespace Modules\Scouting\Database\Factories;

use Modules\Competition\Entities\CompetitionRivalTeam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;

class ScoutingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scouting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        return [
            'competition_match_id' => $competition_match->id,
            'status' => Scouting::STATUS_NOT_STARTED,
            'in_game_time' => ''
        ];
    }
}
