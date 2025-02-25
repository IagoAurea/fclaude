<?php

namespace Modules\Classroom\Services;

use Exception;
use App\Traits\ResponseTrait;

// Repositories
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

// Entities
use Modules\Classroom\Entities\Classroom;
use Modules\Club\Entities\AcademicYear;

class ClassroomAcademicYearService
{
    use ResponseTrait;

    /**
     * @var object $academicYearAlumnRepository
     */
    protected $academicYearAlumnRepository;

    /**
     * @var object $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        ClassroomAcademicYearAlumnRepositoryInterface $academicYearAlumnRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    ) {
        $this->academicYearAlumnRepository = $academicYearAlumnRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
    }

    /**
     * Lists all academical years related to the classroom
     * @return Array
     * 
     * @OA\Schema(
     *  schema="ClassroomAcademicYearListResponse",
     *  type="object",
     *  description="Returns the list of all classroom related academic years",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Classroom academical years"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="club_id", type="int64", example="1"),
     *          @OA\Property(property="title", type="string", example="string"),
     *          @OA\Property(property="start_date", type="string", format="date"),
     *          @OA\Property(property="end_date", type="string", format="date"),
     *          @OA\Property(property="classroom_academic_year_id", type="int64", example="1"),
     *          @OA\Property(property="is_active", type="boolean"),
     *          @OA\Property(
     *              property="pivot",
     *              type="object",
     *              @OA\Property(property="classroom_id", type="int64", example="1"),
     *              @OA\Property(property="academic_year_id", type="int64", example="1"),
     *              @OA\Property(property="id", type="int64", example="1"),
     *          )
     *      ),
     *  ),
     * )
     */
    public function listYears(Classroom $classroom)
    {
        try {
            return $classroom->academicYears;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Assign multiple academical years to a classroom instance
     * @return void
     * 
     * @OA\Schema(
     *  schema="ClassroomAcademicYearStoreResponse",
     *  type="object",
     *  description="Returns the list of all classroom related academic years",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Successfully assigned academical years to the classroom"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null",
     *  ),
     * )
     */
    public function assignYears($yearIds, Classroom $classroom, $physical_teacher_id = null, $tutor_id = null, $subject_id = null) 
    {
        try {
            foreach ($yearIds as $yearId) {
                $this->classroomAcademicYearRepository->create([
                    'academic_year_id' => $yearId,
                    'classroom_id' => $classroom->id,
                    'physical_teacher_id' => $physical_teacher_id,
                    'tutor_id' => $tutor_id,
                    'subject_id' => $subject_id,
                ]);
            }

            return $this->classroomAcademicYearRepository->byClassroomIdAndYearIds($classroom->id, $yearIds);

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Assign the teacher, subject, and tutor to a classroom_academic_year
     * @return void
     * 
     */
    public function assignTeachersToClassroom(
        $classroom_academic_year_id,
        $physical_teacher_id = null,
        $tutor_id = null,
        $subject_id = null
    ) {
        try {
            $payload = [
                'physical_teacher_id' => $physical_teacher_id,
                'tutor_id' => $tutor_id,
                'subject_id' => $subject_id,
            ];

            return $this->classroomAcademicYearRepository->update($payload, $classroom_academic_year_id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Assign multiple academical years to a classroom instance
     * @return void
     * 
     * @OA\Schema(
     *  schema="ClassroomAlumnAcademicYearStoreResponse",
     *  type="object",
     *  description="Successfully added alumns to the classroom",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Successfully added alumns to the classroom"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null",
     *  ),
     * )
     */
    public function assignAlumns($alumnIds, Classroom $classroom, AcademicYear $academicYear)
    {
        try {
            $classroomAcademicYear = $this->classroomAcademicYearRepository->findOneBy([
                'classroom_id' => $classroom->id,
                'academic_year_id' => $academicYear->id
            ]);

            foreach ($alumnIds as $alumnId) {
                $this->academicYearAlumnRepository->create([
                    'classroom_academic_year_id' => $classroomAcademicYear->id,
                    'alumn_id' => $alumnId
                ]);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function remove($alumnId)
    {
        try {
            $academicYearAlumns = $this->academicYearAlumnRepository->findBy([
                'alumn_id' => $alumnId
            ]);

            $academicYearAlumns->each(function ($academicYearAlumn) {
                $academicYearAlumn->delete();
            });
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
