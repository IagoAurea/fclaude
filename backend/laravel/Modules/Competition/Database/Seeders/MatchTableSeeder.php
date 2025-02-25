<?php

namespace Modules\Competition\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;

// Repositories
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRivalTeamRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\WeatherRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\RefereeRepositoryInterface;

class MatchTableSeeder extends BaseSeeder
{
    /**
     * @var int TOTAL_MATCHES
     */
    const TOTAL_MATCHES = 10;

    /**
     * @var object $faker
     */
    protected $faker;

    /**
     * @var object $matchRepository
     */
    protected $matchRepository;

    /**
     * @var object $competitionRepository
     */
    protected $competitionRepository;

    /**
     * @var object $rivalTeamRepository
     */
    protected $rivalTeamRepository;

    /**
     * @var object $weatherRepository
     */
    protected $weatherRepository;

    /**
     * @var object $refereeRepository
     */
    protected $refereeRepository;

    /**
     * Instances a new seeder class
     */
    public function __construct(
        CompetitionMatchRepositoryInterface $matchRepository,
        CompetitionRepositoryInterface $competitionRepository,
        CompetitionRivalTeamRepositoryInterface $rivalTeamRepository,
        WeatherRepositoryInterface $weatherRepository,
        RefereeRepositoryInterface $refereeRepository
    ) {
        $this->matchRepository = $matchRepository;
        $this->competitionRepository = $competitionRepository;
        $this->rivalTeamRepository = $rivalTeamRepository;
        $this->weatherRepository = $weatherRepository;
        $this->refereeRepository = $refereeRepository;
        $this->faker = Factory::create();
    }

    /**
     * Create 10 rival teams per competition stored in database
     * @return void
     */
    private function createRivalTeams()
    {
        // Get all the users
        $comps = $this->competitionRepository->findAll();

        foreach ($comps as $comp) {
            for ($i = 0; $i < self::TOTAL_MATCHES; $i ++) { 
                $data = [
                    'competition_id' => $comp->id,
                    'start_at' => $this->faker->dateTimeBetween('now', '+1 years'),
                    'location' => $this->faker->address(),
                    'match_situation' => $this->faker->randomElement(['V', 'L']),
                    'competition_rival_team_id' => $this->rivalTeamRepository->findAll()->random()->id,
                    'referee_id' => $this->refereeRepository->findAll()->random()->id,
                    'weather_id' => $this->weatherRepository->findAll()->random()->id,
                ];

                // And then just create the country related to an user
                $this->matchRepository->create($data);
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
        $this->createRivalTeams();
    }
}
