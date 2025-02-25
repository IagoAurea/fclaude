<?php

namespace Modules\Tutorship\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Tutorship\Http\Requests\TutorshipRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Tutorship\Services\Interfaces\TutorshipServiceInterface;

class TutorshipController extends BaseController
{
    /**
     * Service
     *
     * @var $tutorshipService
     */
    protected $tutorshipService;

    /**
     * Instances a new controller class
     *
     * @param TutorshipServiceInterface $tutorshipService
     */
    public function __construct(
        TutorshipServiceInterface $tutorshipService
    ) {
        $this->tutorshipService = $tutorshipService;
    }

     /**
     * Retrieve all tests of classroom created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/tutorships/list/user",
     *  tags={"Tutorship"},
     *  summary="List all tutorships created by user authenticate
     *  - Lista todos las tutorias creadas por el usuario",
     *  operationId="list-tutorships-user",
     *  description="List all tutorships created by user authenticate -
     *  Lista todos las tutorias creadas por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllTutorshipsUser()
    {
        $tutorships = $this->tutorshipService->allTutorshipsByUser(Auth::id());

        return $this->sendResponse($tutorships, 'List all tutorships of user');
    }

    /**
     * Display a list of tutorships by their school center
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorship/school-center/{school_center_id}",
     *      tags={"Tutorship"},
     *      summary="Tutorship Index by school center",
     *      operationId="tutorships-by-school-center",
     *      description="Display a list of tutorships by their school center",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
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
    public function index($school_center_id)
    {
        $payload = $this
            ->tutorshipService
            ->getListOfTutorshipsBySchoolCenter([
                'school_center_id' => $school_center_id
            ]);

        return $this->sendResponse($payload, sprintf('List of tutorships by school center %s', $school_center_id));
    }

    /**
     * Display a list of tutorships by their school center
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorship/school-center/{school_center_id}/alumns",
     *      tags={"Tutorship"},
     *      summary="Tutorship Index by school center",
     *      operationId="tutorships-by-school-center-and-alumns",
     *      description="Display a list of tutorships by their school center grouped by alumns",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
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
    public function indexByAlumns($school_center_id)
    {
        $payload = $this->tutorshipService->getListOfTutorshipsBySchoolCenterAndAlumns(
            ['school_center_id' => $school_center_id]
        );

        return $this->sendResponse($payload,
            sprintf('List of tutorships by school center %s grouped by alumns', $school_center_id));
    }

    /**
     * Display a list of tutorships by their school center
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorship/alumn/{alumn_id}",
     *      tags={"Tutorship"},
     *      summary="Tutorship Show by alumn",
     *      operationId="tutorships-by-alumn",
     *      description="Display a list of tutorships by alumns",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
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
    public function showByAlumn($alumn_id)
    {
        try {
            $payload = $this->tutorshipService->getTutorshipsByAlumns(['alumn_id' => $alumn_id]);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The alumn %s does not exist', $alumn_id), [], Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($payload, sprintf('List of tutorships by alumn %s', $alumn_id));
    }

    /**
     * Display a list of tutorships by their school center
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorship/school-center/{school_center_id}/teachers",
     *      tags={"Tutorship"},
     *      summary="Tutorship Index by school center",
     *      operationId="tutorships-by-school-center-and-teachers",
     *      description="Display a list of tutorships by their school center grouped by teachers",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
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
    public function indexByTeachers($school_center_id)
    {
        $payload = $this->tutorshipService->getListOfTutorshipsBySchoolCenterAndTeachers(
            ['school_center_id' => $school_center_id]
        );

        return $this->sendResponse($payload,
            sprintf('List of tutorships by school center %s grouped by teachers', $school_center_id));
    }

    /**
     * Display a tutorships by a given id
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorship/{tutorship_id}",
     *      tags={"Tutorship"},
     *      summary="Tutorship Index by school center",
     *      operationId="tutorships-by-school-center",
     *      description="Display a list of tutorships by their school center",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/tutorshipTypeNotFound"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     */
    public function show($id)
    {
        $payload = $this->tutorshipService->getTutorshipById(['school_center_id' => $id]);

        if ($payload->count() == 0) {
            return $this->sendError(sprintf('The tutorship %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($payload, sprintf('Tutorships by id %s', $id));
    }

    /**
     * Store a new tutorship
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/tutorship/school-center/{school_center_id}",
     *      tags={"Tutorship"},
     *      summary="Store Tutorship",
     *      operationId="tutorships-store",
     *      description="Store a new tutorship",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/school_center_id" ),
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
    public function store(TutorshipRequest $request, $school_center_id)
    {
        $permission = Gate::inspect('store-tutorship');

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $validated = $request->validated();

            $validated['user_id'] = Auth::id();

            $result = $this->tutorshipService->store($school_center_id, $validated);

            return $this->sendResponse($result, 'Tutorship successfully created', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while storing the tutorship',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendResponse($result,
            sprintf('Store a new tutorship to the school center %s', $school_center_id));
    }

    /**
     * Updates a tutorship
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/tutorships/tutorships/{tutorship_type_id}",
     *      tags={"Tutorship"},
     *      summary="Updates a tutorship",
     *      operationId="tutorship-update",
     *      description="Updates a tutorship",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),
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
     *          ref="#/components/responses/tutorshipNotFound"
     *      )
     *  )
     **/
    public function update(Request $request, $tutorship_id)
    {
        try {
            $result = $this->tutorshipService->update($tutorship_id, $request->all());

            return $this->sendResponse($result, 'Tutorship successfully updated', Response::HTTP_CREATED);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The tutorship %s does not exist', $tutorship_id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while updating the tutorship', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destory a tutorship
     *
     * @param int $tutorship_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/tutorships/tutorships/{tutorship_id}",
     *      tags={"Tutorship"},
     *      summary="Destroys a tutorship",
     *      operationId="tutorship-destroy",
     *      description="Deletes a tutorship",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),
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
     *          ref="#/components/responses/tutorshipNotFound"
     *      )
     *  )
     **/
    public function destroy($id)
    {
        $response = $this->tutorshipService->destroy($id);

        if (!$response) {
            return $this->sendError(sprintf('The tutorship %s does not exist', $id), [], Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($response, 'Tutorship deleted', Response::HTTP_NO_CONTENT);
    }
}
