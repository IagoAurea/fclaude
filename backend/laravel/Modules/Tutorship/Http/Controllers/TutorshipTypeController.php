<?php

namespace Modules\Tutorship\Http\Controllers;

use Modules\Tutorship\Services\Interfaces\TutorshipTypeServiceInterface;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Tutorship\Http\Requests\TutorshipTypeRequest;
use Symfony\Component\HttpFoundation\Response;

class TutorshipTypeController extends BaseController
{
    /**
     * Service
     * 
     * @var $tutorshipTypeService
     */
    protected $tutorshipTypeService;

    /**
     * Instances a new controller class
     * 
     * @param TutorshipTypeServiceInterface $tutorshipTypeService
     */
    public function __construct(
        TutorshipTypeServiceInterface $tutorshipTypeService
    ) {
        $this->tutorshipTypeService = $tutorshipTypeService;
    }

    /**
     * Display a list of tutorships types
     * 
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/types",
     *      tags={"Tutorship/Types"},
     *      summary="Tutorship Types Index",
     *      operationId="tutorships-types-index",
     *      description="Display a list of tutorships types",
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
    public function index()
    {
        $payload = $this->tutorshipTypeService->getListOfTutorshipsTypes();

        return $this->sendResponse($payload, 'List of tutorships types');
    }

    /**
     * Display a tutorship type by a given id
     * 
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/types/{tutorship_type_id}",
     *      tags={"Tutorship/Types"},
     *      summary="Competences Show - Details of a given tutorship type",
     *      operationId="tutorship-types-show",
     *      description="Shows the details of a given tutorship type",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_type_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/tutorshipTypeNotFound"
     *      )
     *  )
     */
    public function show($id)
    {
        $payload = $this->tutorshipTypeService->findByIdTranslated($id);

        if ($payload->count() == 0) {
            return $this->sendError(sprintf('The tutorship type %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($payload, sprintf('Tutorship type with the id: %s', $id));
    }

    /**
     * Store a new tutorship type
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/tutorships/types",
     *      tags={"Tutorship/Types"},
     *      summary="Store tutorship types",
     *      operationId="tutorship-types-store",
     *      description="Stores a new tutorship type",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/TutorshipTypeRequest")
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
    public function store(TutorshipTypeRequest $request)
    {
        try {
            $result = $this->tutorshipTypeService->store($request->all());

            return $this->sendResponse($result, 'Tutorship type successfully created', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while storing the tutorship type', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a tutorship type
     * 
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/tutorships/types/{tutorship_type_id}",
     *      tags={"Tutorship/Types"},
     *      summary="Updates a tutorship type",
     *      operationId="tutorship-type-update",
     *      description="Updates a tutorship type",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_type_id" ),
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
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/tutorshipTypeNotFound"
     *      )
     *  )
     **/
    public function update(Request $request, $id)
    {
        try {
            $result = $this->tutorshipTypeService->update($id, $request->all());

            return $this->sendResponse($result, 'Tutorship type successfully updated', Response::HTTP_CREATED);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The tutorship type %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while updating the tutorship type', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destory a tutorship type
     * 
     * @param int $tutorship_type_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/tutorships/types/{tutorship_type_id}",
     *      tags={"Tutorship/Types"},
     *      summary="Destroys a tutorship type",
     *      operationId="tutorship-types-destroy",
     *      description="Deletes a tutorship type",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_type_id" ),
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
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/tutorshipTypeNotFound"
     *      )
     *  )
     **/
    public function destroy($id)
    {
        $response = $this->tutorshipTypeService->destroy($id);

        if (!$response) {
            return $this->sendError(sprintf('The tutorship type %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }
        return $this->sendResponse($response, 'Tutorship type deleted', Response::HTTP_NO_CONTENT);
    }
}
