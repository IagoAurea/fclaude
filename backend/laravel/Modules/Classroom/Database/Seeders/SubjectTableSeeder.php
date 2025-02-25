<?php

namespace Modules\Classroom\Database\Seeders;

use Modules\Classroom\Repositories\Interfaces\SubjectRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use App\Services\BaseSeeder;
use Faker\Factory;

class SubjectTableSeeder extends BaseSeeder
{
    const ACADEMY_SUBJECT_LIMIT = 10;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var object $subjectRepository
     */
    protected $subjectRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        SubjectRepositoryInterface $subjectRepository,
        ClubRepositoryInterface $clubRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->clubRepository = $clubRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createSubjects()
    {
        $filename = "subjects.json";
        $subjects = $this->getDataJson($filename);


        foreach ($subjects as $subject) {
            $payload = [
                'es' => [
                    'name' => $subject['name_spanish'],
                ],
                'en' => [
                    'name' => $subject['name_english'],
                ],
                'code' => $subject['code']
            ];

            $this->subjectRepository->create($payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSubjects();
    }
}
