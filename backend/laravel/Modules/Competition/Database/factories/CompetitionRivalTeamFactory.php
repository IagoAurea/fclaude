<?php

namespace Modules\Competition\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionRivalTeam;

class CompetitionRivalTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompetitionRivalTeam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $competition = new Competition();

        return [
            'competition_id' => $competition->id,
            'rival_team' => $this->faker->name(),
            'image_id' => 1
        ];
    }
}
