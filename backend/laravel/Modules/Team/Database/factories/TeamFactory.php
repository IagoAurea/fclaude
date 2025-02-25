<?php

namespace Modules\Team\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Team\Entities\Team;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'color' => '#f609df',
            'category' => $this->faker->name(),
            'type_id' => 1,
            'modality_id' => 5,
            'season_id' => 1,
            'gender_id' => 2,
            'image_id' => 1,
            'cover_id' => null,
            'sport_id' => 5,
            'club_id' => 3,
            'created_at' => "3021-07-08 22:15:50",
            'updated_at' => "3021-07-08 22:15:50",
        ];
    }
}
