<?php

namespace Modules\Classroom\Database\Seeders;

use Modules\Classroom\Repositories\Interfaces\TeacherAreaRepositoryInterface;
use App\Services\BaseSeeder;

class TeacherAreaTableSeeder extends BaseSeeder
{
    /**
     * @var TeacherAreaRepositoryInterface $teacherAreaRepository
     */
    protected $teacherAreaRepository;

    public function __construct(
        TeacherAreaRepositoryInterface $teacherAreaRepository
    ) {
        $this->teacherAreaRepository = $teacherAreaRepository;
    }

    /**
     * @return void
     */
    protected function createTeacherAreas()
    {
        $filename = "teacher-areas.json";
        $teacherAreas = $this->getDataJson($filename);


        foreach ($teacherAreas as $teacherArea) {
            $payload = [
                'es' => [
                    'name' => $teacherArea['name_spanish'],
                ],
                'en' => [
                    'name' => $teacherArea['name_english'],
                ],
                'code' => $teacherArea['code']
            ];

            $this->teacherAreaRepository->create($payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTeacherAreas();
    }
}
