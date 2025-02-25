<?php

namespace Modules\Competition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Entities\Competition;
use Modules\Player\Entities\Player;
use Modules\Team\Entities\Team;

class CompetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $team = Team::factory()->create();
        Player::factory(['team_id' => $team->id])->create();

        return [
            'team_id' => $team->id,
            'name' => $this->faker->name(),
            'image_id' => 1,
            'type_competition_id' => 1,
            'date_start' => "3021-07-01 00:00:00",
            'date_end' => "3022-07-01 00:00:00",
            'state' => 1,
            'created_at' => "3021-07-08 22:15:50",
            'updated_at' => "3021-07-08 22:15:50",
        ];
    }
}
