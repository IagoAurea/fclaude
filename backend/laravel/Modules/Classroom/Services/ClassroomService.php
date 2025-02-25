<?php

namespace Modules\Classroom\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
// Repositories
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;

// Entities
use Modules\Classroom\Entities\Classroom;
use Modules\Classroom\Exceptions\ActiveYearNotFoundException;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class ClassroomService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var object $academicYearRepository
     */
    protected $academicYearRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        ClassroomRepositoryInterface $classroomRepository,
        AcademicYearRepositoryInterface $academicYearRepository,
        ClassroomAcademicYearService $classroomAcademicYearService,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ResourceRepositoryInterface $resourceRepository,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->classroomRepository = $classroomRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->classroomAcademicYearService = $classroomAcademicYearService;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->resourceRepository = $resourceRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Lists all academical years related to the classroom
     * @return Array
     * 
     * @OA\Schema(
     *  schema="ShowClassroomResponse",
     *  type="object",
     *  description="Returns the list of all classroom related academic years",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Classroom data"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="name", type="string", example="string"),
     *      @OA\Property(property="age_id", type="int64", example="1"),
     *      @OA\Property(property="physical_teacher_id", type="int64", example="1"),
     *      @OA\Property(property="tutor_id", type="int64", example="1"),
     *      @OA\Property(property="subject_id", type="int64", example="1"),
     *      @OA\Property(property="club_id", type="int64", example="1"),
     *      @OA\Property(
     *          property="academic_years",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="club_id", type="int64", example="1"),
     *              @OA\Property(property="title", type="string", example="string"),
     *              @OA\Property(property="start_date", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="end_date", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="classroom_academic_year_id", type="int64", example="1"),
     *              @OA\Property(property="is_active", type="boolean", example="false"),
     *              @OA\Property(
     *                  property="pivot",
     *                  type="object",
     *                  @OA\Property(property="classroom_id", type="int64", example="1"),
     *                  @OA\Property(property="academic_year_id", type="int64", example="1"),
     *                  @OA\Property(property="id", type="int64", example="1"),
     *              )
     *          ),
     *      )
     *  ),
     * )
     */
    public function show(Classroom $classroom)
    {
        try {
            $classroom->academicYears;

            return $classroom;
        } catch (Exception $exception) {
            abort(response()->error("Classroom not found", Response::HTTP_NOT_FOUND));
        }
    }

    public function store($club_id, $request)
    {
        $payload = [
            'club_id' => $club_id,
            'color' => $request->input('color'),
            'name' => $request->input('name'),
            'observations' => $request->input('observations'),
            'age_id' => $request->input('age_id')
        ];

        $activeYearSearch = [
            'club_id' => $club_id,
            'is_active' => true
        ];

        $activeYear = $this->academicYearRepository->findOneBy($activeYearSearch);

        if (!$activeYear) {
            throw new ActiveYearNotFoundException;
        }

        $requestData = $request->all();

        if (isset($requestData['image'])) {
            $imageDataResource = $this->uploadResource('/classrooms', $requestData['image']);
            $resource = $this->resourceRepository->create($imageDataResource);

            if ($resource) {
                $payload['image_id'] = $resource->id;
            }
        }

        if (isset($requestData['cover'])) {
            $coverDataResource = $this->uploadResource('/classrooms', $requestData['cover']);
            $coverResource = $this->resourceRepository->create($coverDataResource);

            if ($coverResource) {
                $payload['cover_id'] = $coverResource->id;
            }
        }
        $classroom = $this->classroomRepository->create($payload);

        $response = $this->classroomAcademicYearService->assignYears([$activeYear->id], $classroom);

        $classroom_academic_year = $this->classroomAcademicYearRepository->findOneBy([
                'academic_year_id' => $activeYear->id,
                'classroom_id' => $classroom->id
            ]);

        $classroom_academic_year_payload = [];

        $user = Auth::user();

        $teacher = $this->teacherRepository->findOneBy(['username' => $user->username]);
        if ($teacher) {
            $classroom_academic_year_payload['physical_teacher_id'] = $teacher->id;
        }

        if ($request->has('tutor_id')) {
            $classroom_academic_year_payload['tutor_id'] = $request->tutor_id;
        }

        $classroom_academic_year->update($classroom_academic_year_payload);

        return $response;
    }

    public function update($request, $club_id, $id)
    {
        $classroom = $this
            ->classroomRepository
            ->findOneBy(['id' => $id, 'club_id' => $club_id]);

        if (!$classroom) {
            throw new ModelNotFoundException;
        }

        $activeYearSearch = [
            'club_id' => $club_id,
            'is_active' => true
        ];

        $activeYear = $this->academicYearRepository->findOneBy($activeYearSearch);

        if (!$activeYear) {
            throw new ActiveYearNotFoundException;
        }

        $requestData = $request->all();
        $payload = $request->only(['observations', 'age_id', 'name', 'color']);


        if (isset($requestData['image'])) {
            $dataResource = $this->uploadResource('/classrooms', $requestData['image']);
            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $payload['image_id'] = $resource->id;
            }
        }

        if (isset($requestData['cover'])) {
            $coverDataResource = $this->uploadResource('/classrooms', $requestData['cover']);
            $coverResource = $this->resourceRepository->create($coverDataResource);

            if ($coverResource) {
                $payload['cover_id'] = $coverResource->id;
            }
        }

        $classroom->update($payload);

        $classroom_academic_year = $this
            ->classroomAcademicYearRepository
            ->findOneBy([
                'academic_year_id' => $activeYear->id,
                'classroom_id' => $classroom->id
            ]);

        $classroom_academic_year_payload = [];

        if ($request->has('physical_teacher_id')) {
            $classroom_academic_year_payload['physical_teacher_id'] = $request->physical_teacher_id;
        }

        if ($request->has('tutor_id')) {
            $classroom_academic_year_payload['tutor_id'] = $request->tutor_id;
        }

        if ($request->has('subject_id')) {
            $classroom_academic_year_payload['subject_id'] = $request->subject_id;
        }

        if ($request->has('subject_text')) {
            $classroom_academic_year_payload['subject_text'] = $request->subject_text;
        }

        $classroom_academic_year->update($classroom_academic_year_payload);

        $classroom = $this
            ->classroomAcademicYearRepository
            ->findOneBy([
                'academic_year_id' => $activeYear->id,
                'classroom_id' => $classroom->id
            ]);

        return [
            'id' => $classroom->classroom->id,
            'age_id' => $classroom->classroom->age_id,
            'observations' => $classroom->classroom->observations,
            'club_id' => $classroom->classroom->club_id,
            'color' => $classroom->classroom->color,
            'image' => $classroom->classroom->image,
            'image_id' => $classroom->classroom->image_id,
            'cover' => $classroom->classroom->cover,
            'cover_id' => $classroom->classroom->cover_id,
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
    }
}
