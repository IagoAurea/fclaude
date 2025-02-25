<?php

namespace Modules\Tutorship\Database\Seeders;

use Modules\Tutorship\Database\Seeders\Fixtures\TutorshipTypesFixturesTrait;
use Modules\Tutorship\Services\Interfaces\TutorshipTypeServiceInterface;
use App\Services\BaseSeeder;

class TutorshipTypesSeeder extends BaseSeeder
{
    use TutorshipTypesFixturesTrait;

    /**
     * @var $tutorshipTypeService
     */
    protected $tutorshipTypeService;
    public function __construct(
        TutorshipTypeServiceInterface $tutorshipTypeService
    ) {
        $this->tutorshipTypeService = $tutorshipTypeService;
    }

    /**
     * @return void
     */
    protected function createTutorshipTypes(array $tutorship_types)
    {
        foreach ($tutorship_types as $tutorship_type) {
            $tutorship_type_payload = [
                'code' => $tutorship_type['code'],
                'en' => [
                    'name' => $tutorship_type['en_name']
                ],
                'es' => [
                    'name' => $tutorship_type['es_name']
                ]
            ];

            $this->tutorshipTypeService->store($tutorship_type_payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTutorshipTypes($this->getTutorshipTypes());
    }
}
