<?php

namespace Modules\Competition\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;

// Repositories
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRivalTeamRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class RivalTeamTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var int TOTAL_RIVAL_TEAMS
     */
    const TOTAL_RIVAL_TEAMS = 3;

    /**
     * @var object $faker
     */
    protected $faker;
    
    /**
     * @var object $competitionRepository
     */
    protected $competitionRepository;

    /**
     * @var object $rivalTeamRepository
     */
    protected $rivalTeamRepository;

    /**
     * @var object $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Instances a new seeder class
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        CompetitionRivalTeamRepositoryInterface $rivalTeamRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->rivalTeamRepository = $rivalTeamRepository;
        $this->resourceRepository = $resourceRepository;
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
            for ($i = 0; $i < random_int(0, self::TOTAL_RIVAL_TEAMS); $i ++) { 
                $image = $this->getImageRandom('rand');

                $dataResource = $this->uploadResource('/rival-teams', $image);
                $resource = $this->resourceRepository->create($dataResource);

                // Randomize the data
                $data = [
                    'rival_team' => ucfirst($this->faker->name),
                    'competition_id' => $comp->id,
                    "image_id" => $resource->id
                ];

                // And then just create the country related to an user
                $this->rivalTeamRepository->create($data);
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
