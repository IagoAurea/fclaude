<?php

namespace Modules\Classroom\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Modules\Address\Services\AddressService;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Classroom\Services\TeacherService;
use Modules\Classroom\Http\Requests\TeacherUpdateRequest;
use Modules\Classroom\Http\Requests\TeacherStoreRequest;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\TeacherAreaRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;

class TeacherController extends BaseController
{
    use TranslationTrait, ResourceTrait;

    const ADDRESS_VALUES = [
        'street',
        'city',
        'postal_code',
        'country_id',
        'province_id',
        'phone',
        'mobile_phone',
    ];

    /**
     * Repository
     *
     * @var $teacherRepository
     */
    protected $teacherRepository;

    /**
     * Repository
     *
     * @var $teacherAreaRepository
     */
    protected $teacherAreaRepository;
    
    /**
     * Repository
     *
     * @var $resourceRepository
     */
    protected $resourceRepository;
    
    /**
     * Service
     *
     * @var $teacherService
     */
    protected $teacherService;

    /**
     * Service
     *
     * @var $addressService
     */
    protected $addressService;

    /**
     * Instances a new controller class
     *
     * @param TeacherRepositoryInterface $teacherRepository
     */
    public function __construct(
        WorkingExperiencesRepositoryInterface $workingExperiencesRepository,
        TeacherRepositoryInterface $teacherRepository,
        TeacherAreaRepositoryInterface $teacherAreaRepository,
        ResourceRepositoryInterface $resourceRepository,
        AddressService $addressService,
        TeacherService $teacherService
    ) {
        $this->workingExperiencesRepository = $workingExperiencesRepository;
        $this->teacherRepository = $teacherRepository;
        $this->teacherAreaRepository = $teacherAreaRepository;
        $this->resourceRepository = $resourceRepository;
        $this->addressService = $addressService;
        $this->teacherService = $teacherService;
    }

    /**
     * Display a list of teachers
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/{club_id}/teachers",
     *      tags={"Classroom"},
     *      summary="Teacher Index - Teacher list",
     *      operationId="teachers-index",
     *      description="Shows a list of teachers of a school center",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function index($club_id)
    {
        $payload = $this->teacherRepository->findBy(['club_id' => $club_id]);

        return $this->sendResponse($payload, $this->translator('list_of_teachers'));
    }

    /**
     * Display a list of teachers areas
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/{club_id}/teacher-areas",
     *      tags={"Classroom"},
     *      summary="Teacher Area - Teacher Area",
     *      operationId="teachers-area",
     *      description="Shows a list of teacher areas",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function areas()
    {
        $payload = $this->teacherAreaRepository->findAllTranslated();

        return $this->sendResponse($payload, $this->translator('list_of_teacher_areas'));
    }

    /**
     * Display a teacher by a given id
     *
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/{club_id}/teachers/{teacher_id}",
     *      tags={"Classroom"},
     *      summary="Teacher Show - Details of a given teacher",
     *      operationId="teachers-show",
     *      description="Shows the details of a given teacher",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Parameter( ref="#/components/parameters/teacher_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function show($club_id, $id)
    {
        $payload = $this->teacherRepository->findOneBy(['id' => $id, 'club_id' => $club_id]);

        $payload->address ?? null;
        $payload->image;
        $payload->cover;
        $payload->tutorships;
        $payload->work_experiences ?? null;
        $payload->position_staff ?? null;
        $payload->area;


        return $this->sendResponse($payload, $this->translator('teacher_info'));
    }

    /**
     * Store a new Teacher
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/classroom/{club_id}/teachers",
     *      tags={"Classroom"},
     *      summary="Store teachers",
     *      operationId="teachers-store",
     *      description="Stores a new teacher",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/TeacherStoreRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          ref="#/components/responses/responseCreated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function store($club_id, TeacherStoreRequest $request)
    {
        $payload = [
            'club_id' => $club_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender_id' => $request->input('gender_id'),
            'username' => $request->input('username'),
            'birth_date' => $request->input('birth_date'),
            'citizenship' => $request->input('citizenship'),
            'position_staff_id' => $request->input('position_staff_id'),
            'responsibility' => $request->input('responsibility'),
            'teacher_area_id' => $request->input('teacher_area_id'),
            'department_chief' => $request->input('department_chief'),
            'class_tutor' => $request->input('class_tutor'),
            'total_courses' => $request->input('total_courses'),
            'study_level_id' => $request->input('study_level_id'),
            'additional_information' => $request->input('additional_information')
        ];

        $requestData = $request->all();

        if (isset($requestData['image'])) {
            $dataResource = $this->uploadResource('/teachers', $requestData['image']);
            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $payload['image_id'] = $resource->id;
            }
        }

        if (isset($requestData['cover'])) {
            $dataResource = $this->uploadResource('/teachers', $requestData['cover']);
            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $payload['cover_id'] = $resource->id;
            }
        }
        $addressData = $request->only(self::ADDRESS_VALUES);

        $teacher = $this->teacherRepository->create($payload);

        if ($teacher) {
            $this->addressService->store($addressData, $teacher);
        }

        $this->teacherService->createWorkingExperiences($teacher->id, $request->work_experiences);

        return $this->sendResponse($teacher, $this->translator('teacher_created'), Response::HTTP_CREATED);
    }

    /**
     * Update Teacher
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/classroom/{club_id}/teachers/{teacher_id}",
     *      tags={"Classroom"},
     *      summary="Updates teachers",
     *      operationId="teachers-update",
     *      description="Updates a teacher",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Parameter( ref="#/components/parameters/teacher_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/TeacherUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function update(TeacherUpdateRequest $request, $club_id, $id)
    {
        $teacher = $this->teacherRepository->findOneBy(['id' => $id, 'club_id' => $club_id]);

        if (!$teacher) {
            return $this->sendError($this->translator('teacher_not_found'));
        }

        $payload = $request->all();

        if (isset($payload['image'])) {
            $dataResource = $this->uploadResource('/teachers', $payload['image']);
            $resource = $this->resourceRepository->create($dataResource);

            if ($resource) {
                $payload['image_id'] = $resource->id;
            }
        }

        $response = $teacher->update($payload);

        $addressData = $request->only(self::ADDRESS_VALUES);

        if ($addressData) {
            $this->addressService->update($addressData, $teacher);
        }

        $this->teacherService->createWorkingExperiences($teacher->id, $request->work_experiences);

        return $this->sendResponse($response, $this->translator('teacher_updated'));
    }

    /**
     * Destory a teacher
     *
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/{club_id}/teachers/{teacher_id}",
     *      tags={"Classroom"},
     *      summary="Destroys a teacher",
     *      operationId="teachers-destroy",
     *      description="Delete a teacher",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/club_id" ),
     *      @OA\Parameter( ref="#/components/parameters/teacher_id" ),
     *      @OA\Response(
     *          response=204,
     *          ref="#/components/responses/resourceDeleted"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function destroy($club_id, $id)
    {
        try {
            $deleteTeacher = $this->teacherRepository->deleteByCriteria([
                'id' => $id, 'club_id' => $club_id
            ]);

            return $this->sendResponse($deleteTeacher, $this->translator('teacher_deleted'));
        } catch(Exception $exception) {
            return $this->sendError('Error delete teacher', $exception->getMessage());
        }
    }
}
