<?php

namespace Modules\Evaluation\Database\Seeders;

use Modules\Evaluation\Repositories\Interfaces\CompetenceRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Evaluation\Database\Seeders\Fixtures\CompetenceFixturesTrait;
use App\Traits\ResourceTrait;
use App\Services\BaseSeeder;
use Faker\Factory;

class CompetenceSeeder extends BaseSeeder
{
    use ResourceTrait;
    use CompetenceFixturesTrait;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $competenceRepository
     */
    protected $competenceRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        CompetenceRepositoryInterface $competenceRepository
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->competenceRepository = $competenceRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createCompetences(array $competences)
    {
        foreach ($competences as $competence) {

            $dataResource = $this->uploadResource('/evaluations/competences', $competence['image']);
            $resource = $this->resourceRepository->create($dataResource);

            $competence_payload = [
                'image_id' => $resource->id,
                'en' => [
                    'name' => $competence['en_name'],
                    'acronym' => $competence['en_acronym'],
                ],
                'es' => [
                    'name' => $competence['es_name'],
                    'acronym' => $competence['es_acronym'],
                ],
            ];

            $this->competenceRepository->create($competence_payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCompetences($this->getCompetences());
    }
}
