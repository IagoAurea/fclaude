<?php

namespace Modules\Player\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Player\Services\PlayerService;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Faker\Factory;

class PlayerTableSeeder extends Seeder
{
    const PLAYERS_LIMIT = 5;
    const MIN_HEIGHT = 120;
    const MAX_HEIGHT = 215;
    const MIN_WEIGHT = 45;
    const MAX_WEIGHT = 145;
    const DECIMALS = 2;
    const FAMILY_MOTHER_CODE = 'mother';
    const FAMILY_FATHER_CODE = 'father';

    /**
     * @var object
     */
    protected $playerService;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $teamRepository;
    
    /**
     * @var object
     */
    protected $positionRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        PlayerService $playerService,
        CountryRepositoryInterface $countryRepository,
        TeamRepositoryInterface $teamRepository,
        SportPositionRepositoryInterface $positionRepository
    ) {
        $this->playerService = $playerService;
        $this->countryRepository = $countryRepository;
        $this->teamRepository = $teamRepository;
        $this->positionRepository = $positionRepository;

        $this->faker = Factory::create();
    }

    /**
     * Get a random country for insertion
     * 
     * @return Object
     */
    private function getRandomCountry()
    {
        $rand_country = null;

        do {
            $rand_country = $this->countryRepository->findAll()->random();
        } while($rand_country->provinces->isEmpty());

        return $rand_country;
    }

    /**
     * Get random familiar data depending on the code sent
     */
    private function generateFamilyData($code)
    {
        return [
            $code . '_full_name' =>  $this->faker->name(),
            $code . '_email' => $this->faker->email(),
            $code . '_mobile_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
            $code . '_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
        ];
    }

    /**
     * Loops through every team and inserts random data on it
     * 
     * @return void
     */
    private function createPlayers()
    {
        // Get all the available teams
        $teams = $this->teamRepository->findAll();

        // Loop though all teams and start storing players into database
        foreach ($teams as $team) {
            for ($i = 0; $i < self::PLAYERS_LIMIT; $i ++) {
                $rand_country = $this->getRandomCountry();
                $rand_position_id = $this->positionRepository->findAll()->random()->id;

                $player_data = [
                    'team_id' => $team->id,
                    'position_id'   =>  $rand_position_id,
                    'laterality_id' => $this->faker->numberBetween(0, 2),
                    'gender_id' => $this->faker->numberBetween(0, 2),
                    'date_birth' => $this->faker->dateTimeBetween('-40 years', '-15 years'),
                    'heart_rate' => $this->faker->numberBetween(60, 100),
                    'height' => $this->faker->numberBetween(self::MIN_HEIGHT, self::MAX_HEIGHT),
                    'weight' => $this->faker->randomFloat(self::DECIMALS, self::MIN_WEIGHT, self::MAX_WEIGHT),
                    'email' => $this->faker->unique()->email(),
                    'agents' => '"["' . $this->faker->name() . '"]"',
                    'full_name' =>  $this->faker->name(),
                    'alias' =>  $this->faker->name(),
                    'shirt_number' => $this->faker->numberBetween(1, 99),
                ];

                $player_address = [
                    'street' => $this->faker->streetAddress(),
                    'postal_code' => $this->faker->postcode(),
                    'city' => $this->faker->city(),
                    'mobile_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
                    'phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
                    'country_id' => $rand_country->id,
                    'province_id' => $rand_country->provinces->random()->id,
                ];

                $mother_data = $this->generateFamilyData(self::FAMILY_MOTHER_CODE);
                
                $father_data = $this->generateFamilyData(self::FAMILY_FATHER_CODE);
                
                $rand_country = $this->getRandomCountry();
        
                $family_address = [
                    'family_address_country_id' => $rand_country->id,
                    'family_address_province_id' => $rand_country->provinces->random()->id,
                    'family_address_street' => $this->faker->streetAddress(),
                    'family_address_postal_code' => $this->faker->postcode(),
                    'family_address_city' => $this->faker->city(),
                ];

                $this->playerService->store(
                    $player_data,
                    $player_address,
                    $mother_data,
                    $father_data,
                    $family_address,
                    NULL,
                    random_int(1, 2),
                );
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPlayers();
    }
}
