<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Evaluation\Repositories\Interfaces\CompetenceRepositoryInterface;
use Modules\Evaluation\Http\Requests\CompetenceRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;

class CompetenceController extends BaseController
{
    use ResourceTrait;

    /**
     * Repository
     * 
     * @var $competenceRepository
     */
    protected $competenceRepository;

    /**
     * Instances a new controller class
     * 
     * @param CompetenceRepositoryInterface $competenceRepository
     */
    public function __construct(CompetenceRepositoryInterface $competenceRepository)
    {
        $this->competenceRepository = $competenceRepository;
    }

    /**
     * Display a list of competences
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/competences",
     *      tags={"Competences"},
     *      summary="Competences Index - Competences list",
     *      operationId="competences-index",
     *      description="Shows a list of competences to be included in a rubric of an evaluation",
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
        $payload = $this->competenceRepository->findAllTranslated();

        return $this->sendResponse($payload, sprintf('List of competences'));
    }

    /**
     * Display a competence by a given id
     * 
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/competences/{competence_id}",
     *      tags={"Competences"},
     *      summary="Competences Show - Details of a given competence",
     *      operationId="competences-show",
     *      description="Shows the details of a given competence",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/competence_id" ),
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
        $payload = $this->competenceRepository->findByIdTranslated($id);

        return $this->sendResponse($payload, sprintf('Competence with the id: %s', $id));
    }

    /**
     * Store a new competence
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/competences",
     *      tags={"Competences"},
     *      summary="Store competences",
     *      operationId="competences-store",
     *      description="Stores a new competence",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/CompetenceRequest")
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
    public function store(CompetenceRequest $request)
    {
        try {
            $payload = $request->all();

            if ($request->image) {
                $dataResource = $this->uploadResource('/evaluation-competences', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $payload['image_id'] = $resource->id;
                }
            }

            $result = $this->competenceRepository->create($payload);

            return $this->sendResponse($result, 'Competence successfully created', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while storing the competence', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a competence
     * 
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/evaluation/competences/{competence_id}",
     *      tags={"Competences"},
     *      summary="Updates competences",
     *      operationId="competences-update",
     *      description="Updates a competence",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/competence_id" ),
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
    public function update(Request $request, $id)
    {
        $competence = $this->competenceRepository->findOneBy(['id' => $id]);

        if (!$competence) {
            return $this->sendError(sprintf('The competence %s does not exist', $competence));
        }

        $requestData = $request->all();
        $payload = $request->all();

        try {
            if (isset($requestData['image'])) {
                $dataResource = $this->uploadResource('/evaluation-competences', $requestData['image']);
                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $payload['image_id'] = $resource->id;
                }
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        $response = $competence->update($payload);

        return $this->sendResponse($response, 'Competence updated');
    }

    /**
     * Destory a competence
     * 
     * @param int $competence_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/ages/{competence_id}",
     *      tags={"Competences"},
     *      summary="Destroys a competence",
     *      operationId="competences-destroy",
     *      description="Deletes a competence",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/competence_id" ),
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
        $response = $this->competenceRepository->findOneBy(['id' => $id]);

        if (!$response) {
            return $this->sendError(sprintf('The competence %s does not exist', $id));
        }

        $response->delete();

        return $this->sendResponse([], 'Competence deleted', Response::HTTP_NO_CONTENT);
    }
}
