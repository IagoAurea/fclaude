<?php

namespace Modules\Nutrition\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\Nutrition\Repositories\Interfaces\WeightControlRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;

class WeightControlTableSeeder extends Seeder
{
    const NUMBER = 3;

    /**
     * @var object
     */
    protected $playerRepository;

    /**
     * @var object
     */
    protected $weightControlRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        WeightControlRepositoryInterface $weightControlRepository,
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->weightControlRepository = $weightControlRepository;
        $this->playerRepository = $playerRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createWeightControl()
    {
        $players = $this->playerRepository->findAll()->take(5);
        foreach ($players as $player) {
            for ($i=0; $i < self::NUMBER ; $i++) { 
                $dataWeightControl = [         
                    "weight" => $this->faker->randomNumber(2, false),
                    "player_id" => $player->id,
                    "team_id" => $player->team->id
                ];
                $this->weightControlRepository->create($dataWeightControl);
            }
        }
    }

    public function run()
    {
        $this->createWeightControl();
    }
}
