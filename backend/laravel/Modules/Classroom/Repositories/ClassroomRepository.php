<?php

namespace Modules\Classroom\Repositories;

use Modules\Club\Entities\Club;
use App\Services\ModelRepository;
use Modules\Classroom\Entities\Classroom;
use Modules\Classroom\Exceptions\ActiveYearNotFoundException;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class ClassroomRepository extends ModelRepository implements ClassroomRepositoryInterface
{
    /**
     * Model
     * @var Classroom $model
     */
    protected $model;

    /**
     * Model
     * @var ClubRepository $clubRepository
     */
    protected $clubRepository;

    /**
     * Model
     * @var AcademicYearRepositoryInterface $academicYearRepository
     */
    protected $academicYearRepository;

    /**
     * Model
     * @var ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * Instances a new repository class
     *
     * @param Classroom $model
     */
    public function __construct(
        Classroom $model,
        ClubRepositoryInterface $clubRepository,
        AcademicYearRepositoryInterface $academicYearRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    ) {
        $this->model = $model;
        $this->clubRepository = $clubRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $relations = [];

        parent::__construct($this->model, $relations);
    }

    /**
     * Finds a list of classrooms by a given user
     *
     * @param int $user_id
     * @return Collection
     */
    public function findByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, Club::ACADEMIC_USER_TYPE);
        $classrooms = collect([]);

        $clubs->each(function ($club) use ($classrooms) {
            $classrooms->push($club->classrooms);
        });

        return array_merge(...$classrooms->toArray());
    }

    /**
     * Finds a list of classrooms by a given club
     *
     * @param int $user_id
     * @return Collection
     */
    public function findByClub($club_id)
    {
        $activeYearSearch = [
            'club_id' => $club_id,
            'is_active' => true
        ];

        $activeYear = $this->academicYearRepository->findOneBy($activeYearSearch);

        if (!$activeYear) {
            throw new ActiveYearNotFoundException;
        }

        return $this->classroomAcademicYearRepository
            ->findBy([
                'academic_year_id' => $activeYear->id
            ])
            ->map(function ($classroom) {
                return [
                    'id' => $classroom->classroom->id,
                    'age_id' => $classroom->classroom->age_id,
                    'observations' => $classroom->classroom->observations,
                    'cover' => $classroom->classroom->cover,
                    'cover_id' => $classroom->classroom->cover_id,
                    'club_id' => $classroom->classroom->club_id,
                    'color' => $classroom->classroom->color,
                    'image' => $classroom->classroom->image,
                    'image_id' => $classroom->classroom->image_id,
                    'name' => $classroom->classroom->name,
                    'active_academic_years' => [
                        'id' => $classroom->academicYear->id,
                        'club_id' => $classroom->academicYear->club_id,
                        'title' => $classroom->academicYear->title,
                        'start_date' => $classroom->academicYear->start_date,
                        'end_date' => $classroom->academicYear->end_date,
                        'is_active' => $classroom->academicYear->is_active,
                        'classroom_academic_year_id' => $classroom->id,
                        'academic_periods' => $classroom->academicYear->academicPeriods
                    ],
                    'tutor' => $classroom->tutor,
                    'subject' => $classroom->subject_text ? $classroom->subject_text : $classroom->subject,
                    'physical_teacher' => $classroom->physicalTeacher,
                ];
            });
    }
}
