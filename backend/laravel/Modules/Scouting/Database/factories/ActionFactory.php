<?php

namespace Modules\Scouting\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Scouting\Entities\Action;
use Illuminate\Support\Str;

class ActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Action::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName();

        return [
            'code' => Str::slug($name, '_'),
            'rival_team_action' => false,
            'side_effect' => 'test',
            'sport_id' => 1
        ];
    }
}
