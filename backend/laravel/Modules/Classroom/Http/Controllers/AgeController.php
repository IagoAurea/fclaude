<?php

namespace Modules\Classroom\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\AgeRepositoryInterface;
use Modules\Classroom\Http\Requests\AgeRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Http\Request;

class AgeController extends BaseController
{
    /**
     * Repository
     *
     * @var $ageRepository
     */
    protected $ageRepository;

    /**
     * Instances a new controller class
     *
     * @param AgeRepositoryInterface $ageRepository
     */
    public function __construct(AgeRepositoryInterface $ageRepository)
    {
        $this->ageRepository = $ageRepository;
    }

    /**
     * Display a list of ages
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/ages",
     *      tags={"Classroom"},
     *      summary="Ages Index - Ages list",
     *      operationId="ages-index",
     *      description="Shows a list of student ages allowed to be registered within a classroom",
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
        $payload = $this->ageRepository->findAll();

        return $this->sendResponse($payload, sprintf('List of ages'));
    }

    /**
     * Display a age by a given id
     *
     * @param int $age_id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/classroom/ages/{age_id}",
     *      tags={"Classroom"},
     *      summary="Ages Show - Details of a given age",
     *      operationId="ages-show",
     *      description="Shows the details of a given student ages",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/age_id" ),
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
    public function show($id)
    {
        $payload = $this->ageRepository->findOneBy(['id' => $id]);

        return $this->sendResponse($payload, sprintf('Age with the id: %s', $id));
    }

    /**
     * Store a new Age
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/classroom/ages",
     *      tags={"Classroom"},
     *      summary="Store ages",
     *      operationId="ages-store",
     *      description="Stores a new age",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/AgeRequest")
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
    public function store(AgeRequest $request)
    {
        $payload = [
            'range' => $request->input('range')
        ];

        $response = $this->ageRepository->create($payload);

        return $this->sendResponse($response, 'Age created', Response::HTTP_CREATED);
    }

    /**
     * Updates an age
     *
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/classroom/ages/{age_id}",
     *      tags={"Classroom"},
     *      summary="Updates ages",
     *      operationId="ages-update",
     *      description="Updates an age",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/age_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/AgeRequest")
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
    public function update(AgeRequest $request, $id)
    {
        $age = $this->ageRepository->findOneBy(['id' => $id]);

        if (!$age) {
            return $this->sendError(sprintf('The age %s does not exist', $age));
        }

        $response = $age->update($request->all());

        return $this->sendResponse($response, 'Age updated');
    }

    /**
     * Destory a age
     *
     * @param int $age_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/ages/{age_id}",
     *      tags={"Classroom"},
     *      summary="Destroys an age",
     *      operationId="ages-destroy",
     *      description="Deletes an age",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/age_id" ),
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
    public function destroy($id)
    {
        $response = $this->ageRepository->findOneBy(['id' => $id]);

        if (!$response) {
            return $this->sendError(sprintf('The age %s does not exist', $id));
        }

        $response->delete();

        return $this->sendResponse([], 'Age deleted', Response::HTTP_NO_CONTENT);
    }
}
