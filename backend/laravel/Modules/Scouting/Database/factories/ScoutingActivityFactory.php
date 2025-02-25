<?php

namespace Modules\Scouting\Database\Factories;

use Modules\Competition\Entities\CompetitionRivalTeam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\Action;
use Carbon\Carbon;

class ScoutingActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScoutingActivity::class;

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

        $scouting = Scouting::factory()->create([
            'competition_match_id' => $competition_match->id,
            'status' => Scouting::STATUS_STARTED
        ]);

        $action = Action::factory()->create();

        return [
            'scouting_id' => $scouting->id,
            'status' => true,
            'action_id' => $action->id,
            'in_game_time' => Carbon::now(),
        ];
    }

    /**
     * Indicate that the activity is a winner activity.
     * (Used for custom sport comparision)
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function winner()
    {
        return $this->state(function (array $attributes) {
            return [
                'custom_params' => ScoutingActivity::WINNER,
            ];
        });
    }
}
