<?php

namespace Modules\Sport\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Sport\Services\SportService;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;

class SportController extends BaseController
{
    /**
     * @var object
     */
    protected $sportService;
    
    /**
     * Creates a new controller instance
     */
    public function __construct(SportService $sportService)
    {
        $this->sportService = $sportService;
    }

    /**
     * Display a listing of the sports.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/sports",
     *  tags={"Sport"},
     *  summary="Sports Index",
     *  operationId="sports-list",
     *  description="Returns a full list of all sports items",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/sports"),
     *  @OA\Parameter(ref="#/components/parameters/scouting"),
     *  @OA\Response(
     *      response=200,
     *      description="Updated alumn daily control",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/SportListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
    */
    public function index(Request $request)
    {
        try {
            $sports = $this->sportService->index($request);

            return $this->sendResponse($sports, 'List Sports');
        } catch (Exception $exception) {
            return $this->sendError('There was an error while listing sport',
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
