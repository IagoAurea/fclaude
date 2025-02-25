<?php

namespace Modules\Player\Database\Factories;

use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Player\Entities\Player;

class PlayerFactory extends Factory
{
    const MIN_HEIGHT = 120;
    const MAX_HEIGHT = 215;
    const MIN_WEIGHT = 45;
    const MAX_WEIGHT = 145;
    const DECIMALS = 2;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        $rand_country = $this->getRandomCountry();
        $rand_position_id = $this->getRandomPosition();

        return [
            'team_id' => 9999999,
            'country_id' => $rand_country->id,
            'province_id' => $rand_country->provinces->random()->id,
            'position_id'   =>  $rand_position_id,
            'laterality_id' => $this->faker->numberBetween(0, 2),
            'gender_id' => $this->faker->numberBetween(0, 2),
            'date_birth' => $this->faker->dateTimeBetween('-40 years', '-15 years'),
            'heart_rate' => $this->faker->numberBetween(60, 100),
            'height' => $this->faker->numberBetween(self::MIN_HEIGHT, self::MAX_HEIGHT),
            'weight' => $this->faker->randomFloat(self::DECIMALS, self::MIN_WEIGHT, self::MAX_WEIGHT),
            'email' => $this->faker->email(),
            'agents' => '"["' . $this->faker->name() . '"]"',
            'full_name' =>  $this->faker->name(),
            'alias' =>  $this->faker->name(),
            'shirt_number' => $this->faker->numberBetween(1, 99),
            'address' => $this->faker->streetAddress(),
            'zipcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'mobile_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
            'phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
        ];
    }

    /**
     * Get a random country for insertion
     * 
     * @return Object
     */
    private function getRandomCountry()
    {
        $countryRepository = app(CountryRepositoryInterface::class);
        $rand_country = null;

        do {
            $rand_country = $countryRepository->findAll()->random();
        } while($rand_country->provinces->isEmpty());

        return $rand_country;
    }

    /**
     * Get a random position for insertion
     * 
     * @return Object
     */
    private function getRandomPosition()
    {
        return app(SportPositionRepositoryInterface::class)
            ->findAll()
            ->random()
            ->id;
    }
}
