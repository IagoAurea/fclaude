<?php

namespace Modules\Nutrition\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\Nutrition\Repositories\Interfaces\NutritionalSheetRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;

class NutritionalSheetTableSeeder extends Seeder
{   
    const NUMBER = 6;

    /**
     * @var object
     */
    protected $playerRepository;

    /**
     * @var object
     */
    protected $nutritionalSheetRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        NutritionalSheetRepositoryInterface $nutritionalSheetRepository,
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->nutritionalSheetRepository = $nutritionalSheetRepository;
        $this->playerRepository = $playerRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createNutritionalSheet()
    {
        $players = $this->playerRepository->findAll()->take(5);
        foreach ($players as $player) {
            $dataNutritionalSheet = [
                "take_supplements" => $this->faker->boolean(),
                "take_diets"       => $this->faker->boolean(),
                "activity_factor"  => $this->faker->randomFloat(2, 0, 2), // 48.8932,
                "total_energy_expenditure" => $this->faker->randomNumber(4, false),  // 79907610 ,
                "other_supplement" => ucfirst($this->faker->name),
                "other_diet"       => ucfirst($this->faker->name),
                "player_id"        => $player->id,
                "team_id"          => $player->team->id,
                "supplements"      =>$this->faker->randomElements(array (1,2,3,4,5,6,7), 3),  
                "diets"            =>$this->faker->randomElements(array (1,2,3,4,5,6,7,8), 3), 
                "athlete_activity" => [
                    "repose"     => $this->faker->randomDigit(),
                    "very_light" => $this->faker->randomDigit(),
                    "light"      => $this->faker->randomDigit(),
                    "moderate"   =>$this->faker->randomDigit(),
                    "intense"    => $this->faker->randomDigit(),
                ]
            ];
            $request = new Request($dataNutritionalSheet);
            $this->nutritionalSheetRepository->createNutritionalSheet($request);
        }
    }

    public function run()
    {
        $this->createNutritionalSheet();
    }
}
