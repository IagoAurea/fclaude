<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreUnitRequest;
use Modules\Test\Http\Requests\UpdateUnitRequest;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;

class UnitController extends BaseController
{
    /**
     * @var $unitRepository
     */
    protected $unitRepository;


    public function __construct(
        UnitRepositoryInterface $unitRepository
    )
    {
        $this->unitRepository = $unitRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/unit",
    *       tags={"Test/Unit"},
    *       summary="Get list unit  - Lista de unidades",
    *       operationId="list-unit",
    *       description="Return data list unit - Retorna el listado de unidades",
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
        $unit = $this->unitRepository->findAllTranslated();

        return $this->sendResponse($unit, 'List of Unit');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/unit",
    *       tags={"Test/Unit"},
    *       summary="Stored Unit - guardar unidad",
    *       operationId="unit-store",
    *       description="Store a new unit - Guarda una nueva unidad",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreUnitRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Store a newly created resource in storage.
     * @param StoreUnitRequest $request
     * @return Response
     */
    public function store(StoreUnitRequest $request)
    {
        try {

            $unitCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                
            ];

            $unit = $this->unitRepository->create($unitCreate);

            return $this->sendResponse($unit, 'Unit stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Unit', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/unit/{code}",
    *       tags={"Test/Unit"},
    *       summary="Show Unit  - Ver los datos de una unidad",
    *       operationId="show-unit",
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

            $unit = $this->unitRepository->findOneBy(["code" => $code]);

            if(!$unit) {
                return $this->sendError("Error", "Unit not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($unit, 'Unit information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Unit ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/unit/{code}",
    *       tags={"Test/Unit"},
    *       summary="Edit Unit  - Editar unidad",
    *       operationId="unit-edit",
    *       description="Edit a unit  - Edita un unidad",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateUnitRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Update the specified resource in storage.
     * @param UpdateUnitRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateUnitRequest $request, $code)
    {
        try {

            $unit = $this->unitRepository->findOneBy(["code" => $code]);

            if(!$unit) {
                return $this->sendError("Error", "Unit not found", Response::HTTP_NOT_FOUND);
            }

            $unitUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->unitRepository->update($unitUpdate, $unit);

             return $this->sendResponse($updated, 'Unit data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Unit', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/unit/{code}",
    *       tags={"Test/Unit"},
    *       summary="Delete Unit  - Elimina un unidad",
    *       operationId="unit-delete",
    *       description="Delete a Unit - Elimina un unidad",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     */
    public function destroy($code)
    {
        try {

            $unit = $this->unitRepository->findOneBy(["code" => $code]);

            if(!$unit) {
                return $this->sendError("Error", "Unit not found", Response::HTTP_NOT_FOUND);
            }

            return $this->unitRepository->delete($unit->id) 
            ? $this->sendResponse(NULL, 'Unit deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Unit Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Unit', $exception->getMessage());
        }
    }
}
