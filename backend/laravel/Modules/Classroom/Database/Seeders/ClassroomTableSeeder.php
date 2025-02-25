<?php

namespace Modules\Classroom\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\AgeRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\SubjectRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

use Faker\Factory;

class ClassroomTableSeeder extends Seeder
{
    const CLASSROOM_LIMIT = 2;

    /**
     * @var object
     */
    protected $classroomRepository;

    /**
     * @var object
     */
    protected $ageRepository;

    /**
     * @var object
     */
    protected $subjectRepository;

    /**
     * @var object
     */
    protected $teacherRepository;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $classroomAcademicYearRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        ClassroomRepositoryInterface $classroomRepository,
        ClubRepositoryInterface $clubRepository,
        AgeRepositoryInterface $ageRepository,
        SubjectRepositoryInterface $subjectRepository,
        TeacherRepositoryInterface $teacherRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    ) {
        $this->classroomRepository = $classroomRepository;
        $this->clubRepository = $clubRepository;
        $this->ageRepository = $ageRepository;
        $this->subjectRepository = $subjectRepository;
        $this->teacherRepository = $teacherRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;

        $this->faker = Factory::create();
    }

    /**
     * Loops through every classroom and inserts random data on it
     * 
     * @return void
     */
    private function createClassooms()
    {
        // Get all academies
        $clubs = $this->clubRepository->findBy([
            'club_type_id' => 2
        ]);

        // Loop though all classrooms and start storing alumns into database
        foreach ($clubs as $club) {
            // Loop through every classroom item
            for ($i = 0; $i < self::CLASSROOM_LIMIT; $i++) {
                // Randomly select all the variables
                $rand_age = $this->ageRepository->findAll()->random();
                $rand_subject = $this->subjectRepository->findAll()->random();
                $rand_physical_teacher = $this->teacherRepository->findBy([
                    'club_id' => $club->id
                ])->random();
                $rand_tutor = $this->teacherRepository->findBy([
                    'club_id' => $club->id
                ])->random();

                $payload = [
                    'name' => $this->faker->name(),
                    'club_id' => $club->id,
                    'color' => $this->faker->hexcolor,
                    'age_id' => $rand_age->id,
                    'observations' => $this->faker->text(random_int(50, 120))
                ];

                // Do the classroom insertion into the database
                $classroom = $this->classroomRepository->create($payload);

                // Relate the classroom to both club academical years
                foreach ($club->academicYears as $academicYear) {
                    $this->classroomAcademicYearRepository->create([
                        'academic_year_id' => $academicYear->id,
                        'classroom_id' => $classroom->id,
                        'physical_teacher_id' => $rand_physical_teacher->id,
                        'tutor_id' => $rand_tutor->id,
                        'subject_id' => $rand_subject->id,
                    ]);
                }
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
        $this->createClassooms();
    }
}
