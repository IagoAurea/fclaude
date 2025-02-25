<?php

namespace Modules\Classroom\Http\Controllers;

use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\SubjectRepositoryInterface;
use Modules\Classroom\Http\Requests\SubjectRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;
use Exception;

class SubjectController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * Repository
     * 
     * @var $subjectRepository
     */
    protected $subjectRepository;

    /**
     * Instances a new controller class
     * 
     * @param SubjectRepositoryInterface $subjectRepository
     */
    public function __construct(
        SubjectRepositoryInterface $subjectRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * Display a list of subjects
     * 
     * @param int $club_id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/subjects",
     *      tags={"Classroom"},
     *      summary="Subjects Index - Subjects list",
     *      operationId="subjects-index",
     *      description="Shows a list of subjects of a school center",
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
    public function index()
    {
        $payload = $this->subjectRepository->findAllTranslated();

        return $this->sendResponse($payload, $this->translator('list_of_subjects'));
    }

    /**
     * Display a subject by a given id
     * 
     * @param int $subject_id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/subjects/{subject_code}",
     *      tags={"Classroom"},
     *      summary="Subject Show - Details of a given subject",
     *      operationId="subjects-show",
     *      description="Shows the details of a given subject",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/subject_code" ),
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
    public function show($code)
    {
        try {
            $payload = $this->subjectRepository->findOneBy(['code' => $code]);

            if (!$payload) {
                return $this->sendError(
                    $this->translator('error_subject_not_found'),
                    $this->translator('error_subject_not_found'),
                    Response::HTTP_NOT_FOUND
                );
            }

            return $this->sendResponse($payload, $this->translator('subject_information'));
        } catch (Exception $exception) {
            return $this->sendError($this->translator('error_retrieving_subject'), $exception->getMessage());
        }
    }

    /**
     * Store a new Subject
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/classroom/subjects",
     *      tags={"Classroom"},
     *      summary="Store subjects",
     *      operationId="subjects-store",
     *      description="Stores a new subject",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/SubjectRequest")
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
    public function store(SubjectRequest $request)
    {
        try {
            $payload = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $requestData = $request->all();

            if (isset($requestData['image'])) {
                $dataResource = $this->uploadResource('/subjects', $requestData['image']);
                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $payload['image_id'] = $resource->id;
                }
            }

            $phase = $this->subjectRepository->create($payload);

            return $this->sendResponse($phase, $this->translator('subject_created'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('error_creating_subject'), $exception->getMessage());
        }
    }

    /**
     * Update Subject
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/classroom/subjects/{subject_code}",
     *      tags={"Classroom"},
     *      summary="Updates subjects",
     *      operationId="subjects-update",
     *      description="Updates a subject",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/subject_code" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/SubjectRequest")
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
    public function update(SubjectRequest $request, $code)
    {
        $subject = $this->subjectRepository->findOneBy(['id' => $code]);

        if (!$subject) {
            return $this->sendError(
                $this->translator('error_subject_not_found'),
                $this->translator('error_subject_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $requestData = $request->all();
        $payload = $request->all();

        try {
            if (isset($requestData['image'])) {
                $dataResource = $this->uploadResource('/subjects', $requestData['image']);
                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $payload['image_id'] = $resource->id;
                }
            }
        } catch (Exception $exception) {
            throw $exception;
        }

        $response = $subject->update($payload);

        return $this->sendResponse($response, $this->translator('subject_updated'));
    }

    /**
     * Destory a subject
     * 
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/subjects/{subject_code}",
     *      tags={"Classroom"},
     *      summary="Destroys a subject",
     *      operationId="subjects-destroy",
     *      description="Deletes a subject",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/subject_code" ),
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
    public function destroy($code)
    {
        $response = $this->subjectRepository->findOneBy(['code' => $code]);

        if (!$response) {
            return $this->sendError(
                $this->translator('error_subject_not_found'),
                $this->translator('error_subject_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $response->delete();

        return $this->sendResponse([], $this->translator('subject_deleted'), Response::HTTP_NO_CONTENT);
    }
}
