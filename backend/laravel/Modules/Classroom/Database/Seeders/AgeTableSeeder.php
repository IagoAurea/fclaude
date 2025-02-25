<?php

namespace Modules\Classroom\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\AgeRepositoryInterface;
use Modules\Classroom\Database\Seeders\Fixtures\AgeFixturesTrait;

class AgeTableSeeder extends BaseSeeder
{
    use ResourceTrait;
    use AgeFixturesTrait;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $ageRepository
     */
    protected $ageRepository;
    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        AgeRepositoryInterface $ageRepository
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->ageRepository = $ageRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createAge(array $ages)
    {
        foreach ($ages as $age) {
            $age_payload = [
                'range' => $age
            ];

            $this->ageRepository->create($age_payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAge($this->getAges());
    }
}
