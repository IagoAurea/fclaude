<?php

namespace Modules\Generality\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Http\Requests\RefereeRequest;
use Modules\Generality\Repositories\Interfaces\RefereeRepositoryInterface;

class RefereesController extends BaseController
{
    /**
     * Referee repository
     * @var $refereeRepository
     */
    protected $refereeRepository;

    /**
     * RefereesController constructor.
     * @param RefereeRepositoryInterface $refereeRepository
     */
    public function __construct(RefereeRepositoryInterface $refereeRepository)
    {
        $this->refereeRepository = $refereeRepository;
    }

    /**
     * @OA\Get(
     *  path="/api/v1/referees/{team_id}",
     *  tags={"Referees"},
     *  summary="Shows referees/ by team",
     *  operationId="referee-list",
     *  description="Shows list referees by team - Muestra listado de arbitros por equipo",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(ref="#/components/parameters/_locale"),
     *   @OA\Parameter(ref="#/components/parameters/team_id"),
     *  @OA\Response(
     *      response=200,
     *      description="Returns information referees by team",
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
    /**
     * Get all referees/by team
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $filter = [];

        if($request->team_id) {
            $filter['team_id'] = $request->team_id;
        }

        $referees = $this->refereeRepository->findBy($filter);

        return $this->sendResponse($referees, 'List Referees');
    }

    /**
     *  @OA\Post(
     *  path="/api/v1/referees",
     *  tags={"Referees"},
     *  summary="Stored Referee - Guarda un arbitro",
     *  operationId="referee-store",
     *  description="Store a new referee - Guarda un nuevo arbitro",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(ref="#/components/schemas/StoreRefereeRequest")
     *     )
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
    /**
     * Endpoint to create a referee
     * @param RefereeRequest $request
     * @return JsonResponse
     */
    public function store(RefereeRequest $request)
    {
        $refereeData = $request->all();
        try {
            $refereeData = $this->refereeRepository->create($refereeData);

            return $this->sendResponse($refereeData, 'Referee created!', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('An error has occurred!', $exception->getMessage());
        }
    }

    /**
     * Endpoint to update a Referee
     * @param $id
     * @param RefereeRequest $request
     * @return JsonResponse
     */
    public function update($id, RefereeRequest $request)
    {
        $referee = $this->refereeRepository->find($id);
        if (!$referee) return $this->sendError("Referee not found", "NOT_FOUND", 404);

        $refereeData = $request->all();
        try {
            $refereeData = $this->refereeRepository->update($refereeData, [
                "id" => $id
            ]);
            return $this->sendResponse($refereeData, 'Referee updated!');
        } catch (\Exception $e) {
            return $this->sendError('An error has occurred!', $e->getMessage());
        }
    }

    /**
     * Endpoint to delete a Referee
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $referee = $this->refereeRepository->find($id);
        if (!$referee) return $this->sendError("Referee not found", "NOT_FOUND", 404);

        try {
            $weather = $this->refereeRepository->delete($id);
            return $this->sendResponse($weather, 'Referee deleted!', 200);
        } catch (\Exception $e) {
            return $this->sendError("An error has occurred trying to delete a Referee!", $e->getMessage());
        }
    }
}
