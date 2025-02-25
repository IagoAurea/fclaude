<?php

namespace Modules\Alumn\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;

class ClassroomAcademicYearAlumnTableSeeder extends Seeder
{
    const MAX_ALUMNS = 5;

    /**
     * @var $alumnRepository
     */
    protected $alumnRepository;

    /**
     * @var $academicYearAlumnRepository
     */
    protected $academicYearAlumnRepository;

    /**
     * @var $classroomRepository
     */
    protected $classroomRepository;

    /**
     * Create a new seeder instance
     */
    public function __construct(
        AlumnRepositoryInterface $alumnRepository,
        ClassroomAcademicYearAlumnRepositoryInterface $academicYearAlumnRepository,
        ClassroomRepositoryInterface $classroomRepository
    ) {
        $this->alumnRepository = $alumnRepository;
        $this->academicYearAlumnRepository = $academicYearAlumnRepository;
        $this->classroomRepository = $classroomRepository;
    }

    /**
     * @return void
     */
    protected function createClassroomAcademicYearAlumns()
    {
        $alumnGroups = $this->alumnRepository->findAll()->chunk(self::MAX_ALUMNS)->toArray();
        $classrooms = $this->classroomRepository->findAll();
        $index = 0;

        foreach ($classrooms as $classroom) {
            foreach ($classroom->academicYears as $academicYear) {
                foreach ($alumnGroups[$index] as $alumn) {
                    $this->academicYearAlumnRepository->create([
                        'classroom_academic_year_id' => $academicYear->classroom_academic_year_id,
                        'alumn_id' => $alumn['id'],
                    ]);
                }

                $index ++;
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
        $this->createClassroomAcademicYearAlumns();
    }
}
