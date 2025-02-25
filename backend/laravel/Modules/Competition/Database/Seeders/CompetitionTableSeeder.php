<?php

namespace Modules\Competition\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;

class CompetitionTableSeeder extends BaseSeeder
{   
    use ResourceTrait;

    const NUMBERS_COMPETITIONS= 3;

    /**
     * @var object
     */
    protected $teamRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * repository
     * @var $typeCompetitionRepository
     */
    protected $typeCompetitionRepository;

    /**
     * repository
     * @var $competitionRepository
     */
    protected $competitionRepository;

    /**
     * Instances a new seeder class.
     */
    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ResourceRepositoryInterface $resourceRepository,
        TypeCompetitionRepositoryInterface $typeCompetitionRepository,
        CompetitionRepositoryInterface $competitionRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->resourceRepository = $resourceRepository;
        $this->typeCompetitionRepository = $typeCompetitionRepository;
        $this->competitionRepository = $competitionRepository;
        $this->faker = Factory::create();
    }

    /**
     * In this method we only create 1 club per user, by looping through every previously
     * stored user in the database.
     * 
     * @return \Iterator
     */
    private function runSeeder()
    {
        // Get all the users
        $teams = $this->teamRepository->findAll();

        $format = 'Y-m-d';

        foreach ($teams as $team) {
            // Initialize the random country as a null value
            for ($i=0; $i < random_int(0, self::NUMBERS_COMPETITIONS); $i++) { 
                $typeCompetition = $this->typeCompetitionRepository->getRandom()->first();
                $image = $this->getImageRandom('rand');

                $dataResource = $this->uploadResource('/competitions', $image);
                $resource = $this->resourceRepository->create($dataResource);

                // Randomize the data
                $data = [
                    'name' => 'Competition '.ucfirst($this->faker->name),
                    'team_id' => $team->id,
                    'type_competition_id' => $typeCompetition->id,
                    'date_start' => $this->faker->dateTimeBetween('-1 week', '+0 days'),
                    'date_end' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
                    "image_id" => $resource->id
                ];

                // And then just create the country related to an user
                $this->competitionRepository->create($data);
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
        $this->runSeeder();
    }
}
