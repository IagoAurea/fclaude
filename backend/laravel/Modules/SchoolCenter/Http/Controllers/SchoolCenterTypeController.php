<?php

namespace Modules\SchoolCenter\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;

// Services
use Modules\SchoolCenter\Services\SchoolCenterTypeService;

class SchoolCenterTypeController extends BaseController
{
    /**
     * @var $schoolCenterTypeService
     */
    protected $schoolCenterTypeService;

    /**
     * Instances a new controller class
     */
    public function __construct(
        SchoolCenterTypeService $schoolCenterTypeService
    ) {
        $this->schoolCenterTypeService = $schoolCenterTypeService;
    }

    /**
     * Display all the academies related to the user doing the request.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/school-center-types",
     *  tags={"School/Types"},
     *  summary="School Center Type Index - Listado de Tipos de Escuela",
     *  operationId="school-center-types-index",
     *  description="Shows a list of all school center types",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      description="Data of school with the academic years items",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ListSchoolCenterTypeResponse"
     *      )
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
    public function index()
    {
        try {
            $types = $this->schoolCenterTypeService->index();
            return $this->sendResponse($types, 'School center type list');
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving school center type lists',
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
