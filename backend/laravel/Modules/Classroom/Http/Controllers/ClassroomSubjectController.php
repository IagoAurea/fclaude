<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\Classroom\Http\Requests\ClassroomSubjectStoreRequest;
use Modules\Classroom\Http\Requests\ClassroomSubjectRemoveRequest;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomSubjectRepositoryInterface;

class ClassroomSubjectController extends BaseController
{
    use TranslationTrait;

    /**
     * @var object $classroomSubjectRepository
     */
    protected $classroomSubjectRepository;

    /**
     * @var object $teacherRepository
     */
    protected $teacherRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        ClassroomSubjectRepositoryInterface $classroomSubjectRepository,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->classroomSubjectRepository = $classroomSubjectRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * List all teachers by school center and classroom with their subjects associated
     * @return Response
     * 
     * @OA\Get(
     *   path="/api/v1/school-center/{club_id}/classroom/{classroom_id}/teachers-subjects",
     *   tags={"Classroom/Subjects"},
     *   summary="Retrieves all the teachers by school center and classroom with their subjects associated",
     *   operationId="list-classroom-subjects-teachers",
     *   description="Returns a list of all teachers by school center and classroom with their subjects associated",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/club_id"),
     *   @OA\Parameter( ref="#/components/parameters/classroom_id"),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function index($club_id, $classroom_id)
    {
        $teachers = $this->teacherRepository->findBy(['club_id' => $club_id])
                    ->pluck('id');

        $teachers_with_subjects_classroom = $this->classroomSubjectRepository->findIn('teacher_id', $teachers->toArray())
                ->where('classroom_id', $classroom_id);

        return $this->sendResponse($teachers_with_subjects_classroom, $this->translator('list_of_teachers_with_subjects'));
    }

    /**
     * Associate a subject to a teacher
     * @return Response
     * 
     * @OA\Post(
     *   path="/api/v1/school-center/{club_id}/classroom/{classroom_id}/teachers-subjects",
     *   tags={"Classroom/Subjects"},
     *   summary="Associate a subject to a teacher",
     *   operationId="associate-subjects-with-teachers",
     *   description="Associate a subject to a teacher",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/club_id"),
     *   @OA\Parameter( ref="#/components/parameters/classroom_id"),
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/ClassroomSubjectStoreRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function store(ClassroomSubjectStoreRequest $request, $club_id, $classroom_id)
    {
        $payload = [
            'teacher_id' => $request->input('teacher_id'),
            'subject_id' => $request->input('subject_id'),
            'classroom_id' => $classroom_id,
            'is_class_tutor' => $request->input('is_class_tutor')
        ];

        $response = $this->classroomSubjectRepository->create($payload);

        return $this->sendResponse($response, $this->translator('teachers_with_subjects_created'), Response::HTTP_CREATED);
    }

    /**
     * Remove a subject to a teacher of classroom
     * @return Response
     * 
     * @OA\Post(
     *   path="/api/v1/school-center/{club_id}/classroom/{classroom_id}/remove/teachers-subjects",
     *   tags={"Classroom/Subjects"},
     *   summary="Remove a classroom subject to a teacher",
     *   operationId="remove-classroom-subjects-teachers",
     *   description="Remove a classroom subject to a teacher",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/club_id"),
     *   @OA\Parameter( ref="#/components/parameters/classroom_id"),
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/ClassroomSubjectRemoveRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function remove(ClassroomSubjectRemoveRequest $request, $club_id, $classroom_id)
    {
        try {
            $remove_teacher = $this->classroomSubjectRepository->deleteByCriteria([
                'classroom_id' => $classroom_id,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id
            ]);

            return $this->sendResponse($remove_teacher, 'Remove classroom subject to teacher successfully');
        } catch(Exception $exception) {
            return $this->sendError('Error by retrieving activities', $exception->getMessage());
        }
    }
}
