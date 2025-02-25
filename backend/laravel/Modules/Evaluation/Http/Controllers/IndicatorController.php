<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Evaluation\Repositories\Interfaces\IndicatorRepositoryInterface;
use Modules\Evaluation\Http\Requests\IndicatorRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request;

class IndicatorController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * Repository
     * 
     * @var $indicatorRepository
     */
    protected $indicatorRepository;

    /**
     * Instances a new controller class
     * 
     * @param IndicatorRepositoryInterface $indicatorRepository
     */
    public function __construct(IndicatorRepositoryInterface $indicatorRepository)
    {
        $this->indicatorRepository = $indicatorRepository;
    }

    /**
     * Display a list of indicators
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/indicators",
     *      tags={"Indicators"},
     *      summary="Indicators Index - Indicators list",
     *      operationId="indicators-index",
     *      description="Shows a list of indicators to be included in a rubric of an evaluation",
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
        $payload = $this->indicatorRepository->withoutRubrics();

        return $this->sendResponse($payload, sprintf('List of indicators'));
    }

    /**
     * Display a indicator by a given id
     * 
     * @param int $id
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/indicators/{indicator_id}",
     *      tags={"Indicators"},
     *      summary="Indicators Show - Details of a given indicator",
     *      operationId="indicators-show",
     *      description="Shows the details of a given indicator",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/indicator_id" ),
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
        $payload = $this->indicatorRepository->findBy(['id' => $id]);

        return $this->sendResponse($payload, sprintf('Indicator with the id: %s', $id));
    }

    /**
     * Store a new indicator
     * 
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/indicators",
     *      tags={"Indicators"},
     *      summary="Store indicators",
     *      operationId="indicators-store",
     *      description="Stores a new indicator",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/IndicatorRequest")
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
    public function store(IndicatorRequest $request)
    {
        try {
            $payload = $request->all();

            $result = $this->indicatorRepository->create($payload);

            if ($request->has('competences')) {
                $competences = explode(',', $request->competences);

                $this->indicatorRepository->assignCompetencesToIndicator($result->id, $competences);
            }

            $result->competences;

            return $this->sendResponse($result, $this->translator('indicator_store'), Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->sendError('There was an error while storing the indicator',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Updates a indicator
     * 
     * @param Request $request
     * @param int $request
     * @return Response
     */
    /**
     *  @OA\Put(
     *      path="/api/v1/evaluation/indicators/{indicator_id}",
     *      tags={"Indicators"},
     *      summary="Updates indicators",
     *      operationId="indicators-update",
     *      description="Updates a indicator",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/indicator_id" ),
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
        $indicator = $this->indicatorRepository->findOneBy(['id' => $id]);

        if (!$indicator) {
            return $this->sendError($this->translator('indicator_not_exist'));
        }

        $response = $indicator->update($request->all());

        if ($request->has('competences')) {
            $competences = explode(',', $request->competences);

            $this->indicatorRepository->assignCompetencesToIndicator($id, $competences);
        }

        return $this->sendResponse($response, $this->translator('indicator_store'));
    }

    /**
     * Destory a indicator
     * 
     * @param int $indicator_id
     * @return Response
     */
    /**
     *  @OA\Delete(
     *      path="/api/v1/classroom/ages/{indicator_id}",
     *      tags={"Indicators"},
     *      summary="Destroys a indicator",
     *      operationId="indicators-destroy",
     *      description="Deletes a indicator",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/indicator_id" ),
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
        $response = $this->indicatorRepository->findOneBy(['id' => $id]);

        if (!$response) {
            return $this->sendError($this->translator('indicator_not_exist'));
        }

        $response->delete();

        return $this->sendResponse(null, $this->translator('indicator_delete'), Response::HTTP_NO_CONTENT);
    }
}
