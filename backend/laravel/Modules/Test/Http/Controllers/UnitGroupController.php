<?php

namespace Modules\Test\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Exception;
use Modules\Test\Repositories\Interfaces\UnitGroupRepositoryInterface;

class UnitGroupController extends BaseController
{
    /**
     * @var $unitGroupRepository
     */
    protected $unitGroupRepository;


    public function __construct(
        UnitGroupRepositoryInterface $unitGroupRepository
    ) {
        $this->unitGroupRepository = $unitGroupRepository;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/unit-group",
     *       tags={"Test/Unit Group"},
     *       summary="Get list unit groups - Lista de group de unidades",
     *       operationId="list-unit-groups",
     *       description="Return data list unit - Retorna el listado de grupo de unidades",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Display a listing of Units.
     * @return Response
     */
    public function index()
    {
        $unit_groups = $this->unitGroupRepository->findAll()->groupBy('code');

        return $this->sendResponse($unit_groups, 'List of unit groups');
    }

    /**
     * @OA\Get(
     *       path="/api/v1/tests/unit-group/{code}",
     *       tags={"Test/Unit Group"},
     *       summary="Show Unit Group - Ver los datos de un grupo de unidades",
     *       operationId="show-unit-group",
     *       description="Return data to Unit  - Retorna los datos de una unidad",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        try {
            $unit_group = $this->unitGroupRepository->findBy(['code' => $code])->groupBy('code');

            if (!$unit_group) {
                return $this->sendError('Error', sprintf('Unit group %s not found', $code), Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($unit_group, sprintf('Unit group information %s', $code));
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving unit group', $exception->getMessage());
        }
    }
}
