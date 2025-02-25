<?php

namespace Modules\Club\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Club\Http\Requests\StorePositionStaffRequest;
use Modules\Club\Http\Requests\UpdatePositionStaffRequest;
use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;

class PositionStaffController extends BaseController
{
    /**
     * @var $targetSessionRepository
     */
    protected $positionStaffRepository;


    public function __construct(
        PositionStaffRepositoryInterface $positionStaffRepository
    )
    {
        $this->positionStaffRepository = $positionStaffRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/clubs/position-staff/staff",
    *       tags={"Club"},
    *       summary="Get list position staff - Lista de cargos ",
    *       operationId="list-position-staff",
    *       description="Return data list position staff  - Retorna listado de cargos ",
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
     * Display a listing of positions.
     * @return Response
     */
    public function index()
    {
        $positionStaff = $this->positionStaffRepository->findAllTranslated();

        return $this->sendResponse($positionStaff, 'List Positions Staff');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/clubs/position-staff/position",
    *       tags={"Club"},
    *       summary="Stored Positions Staff - guardar un nuevo cargo ",
    *       operationId="position-staff-store",
    *       description="Store a new position staff - Guarda un nuevo cargo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StorePositionStaffRequest")
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
     * @param StorePositionStaffRequest $request
     * @return Response
     */
    public function store(StorePositionStaffRequest $request)
    {
        try {

            $positionStaffCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $positionStaff = $this->positionStaffRepository->create($positionStaffCreate);

            return $this->sendResponse($positionStaff, 'Position Staff stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Position Staff', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/clubs/position-staff/{code}",
    *       tags={"Club"},
    *       summary="Show position staff - Ver los datos de un cargo",
    *       operationId="show-position-staff",
    *       description="Return data to position staff  - Retorna los datos de un cargo",
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

            $positionStaff = $this->positionStaffRepository->findOneBy(["code" => $code]);

            if(!$positionStaff) {
                return $this->sendError("Error", "Position Staff not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($positionStaff, 'Position Staff information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Position Staff ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/clubs/position-staff/{code}",
    *       tags={"Club"},
    *       summary="Edit position staff - Editar un cargo",
    *       operationId="position-staff-edit",
    *       description="Edit a position staff - Edita un cargo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdatePositionStaffRequest")
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
     * @param UpdatePositionStaffRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdatePositionStaffRequest $request, $code)
    {
        try {
            $positionStaff = $this->positionStaffRepository->findOneBy(["code" => $code]);

            if(!$positionStaff) {
                return $this->sendError("Error", "Position Staff not found", Response::HTTP_NOT_FOUND);
            }

            $positionStaffUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->positionStaffRepository->update($positionStaffUpdate, $positionStaff);

             return $this->sendResponse($updated, 'Position Staff  data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Position Staff ', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/clubs/position-staff/{code}",
    *       tags={"Club"},
    *       summary="Delete position staff - Elimina un cargo",
    *       operationId="position-staff-delete",
    *       description="Delete a position staff - Elimina un cargo",
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

            $positionStaff = $this->positionStaffRepository->findOneBy(["code" => $code]);

            if(!$positionStaff) {
                return $this->sendError("Error", "Position Staff not found", Response::HTTP_NOT_FOUND);
            }

            return $this->positionStaffRepository->delete($positionStaff->id) 
            ? $this->sendResponse(NULL, 'Position Staff deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Position Staff Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Position Staff', $exception->getMessage());
        }
    }
    
}
