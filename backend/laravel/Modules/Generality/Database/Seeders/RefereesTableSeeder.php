<?php

namespace Modules\Generality\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\RefereeRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ProvinceRepositoryInterface;

class RefereesTableSeeder extends BaseSeeder
{
    /**
     * @var int TOTAL_REFEREE_COUNT
     */
    const TOTAL_REFEREE_COUNT = 30;

    /**
     * @var object $refereeRepository
     */
    protected $refereeRepository;

    /**
     * @var object $countryRepository
     */
    protected $countryRepository;

    /**
     * @var object $provinceRepository
     */
    protected $provinceRepository;

    /**
     * @var object $teamRepository
     */
    protected $teamRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        RefereeRepositoryInterface $refereeRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository,
        TeamRepositoryInterface $teamRepository
    ) {
        $this->refereeRepository = $refereeRepository;
        $this->countryRepository = $countryRepository;
        $this->provinceRepository = $provinceRepository;
        $this->teamRepository = $teamRepository;
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
        } while ($rand_country->provinces->isEmpty());

        return $rand_country;
    }

    /**
     * Create 50 referees radomnly stored in database
     * @return void
     */
    private function createReferees()
    {
        for ($i = 0; $i < self::TOTAL_REFEREE_COUNT; $i++) {
            // Get a random country
            $randCountry = $this->getRandomCountry();

            // Randomize the data
            $data = [
                'name' => $this->faker->name,
                'country_id' => $randCountry->id,
                'province_id' => $randCountry->provinces->random()->id,
                'team_id' => $this->teamRepository->findAll()->random()->id,
            ];

            // And then just create the referee item
            $this->refereeRepository->create($data);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createReferees();
    }
}
