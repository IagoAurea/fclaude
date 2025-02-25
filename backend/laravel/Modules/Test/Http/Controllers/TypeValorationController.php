<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreTypeValorationRequest;
use Modules\Test\Http\Requests\UpdateTypeValorationRequest;
use Modules\Test\Repositories\Interfaces\TypeValorationRepositoryInterface;

class TypeValorationController extends BaseController
{
   /**
     * @var $typeValorationRepository
     */
    protected $typeValorationRepository;


    public function __construct(
        TypeValorationRepositoryInterface $typeValorationRepository
    )
    {
        $this->typeValorationRepository = $typeValorationRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/type-valoration",
    *       tags={"Test/Valoration"},
    *       summary="Get list type valoration  - Lista de tipos de valoración para los test",
    *       operationId="list-type-valoration",
    *       description="Return data list type valoration - Retorna el listado de tipos de valoración",
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
     * Display a listing of types valoration.
     * @return Response
     */
    public function index()
    {
        $typeValoration = $this->typeValorationRepository->findAllTranslated();

        return $this->sendResponse($typeValoration, 'List of Type Valoration');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/type-valoration",
    *       tags={"Test/Valoration"},
    *       summary="Stored type valoration - guardar tipo de valoración",
    *       operationId="/type-valoration-store",
    *       description="Store a new type valoration - Guarda un nuevo tipo de valoración",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreTypeValorationRequest")
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
     * @param StoreTypeValorationRequest $request
     * @return Response
     */
    public function store(StoreTypeValorationRequest $request)
    {
        try {

            $typeValorationCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                
            ];

            $typeValoration = $this->typeValorationRepository->create($typeValorationCreate);

            return $this->sendResponse($typeValoration, 'Type Valoration stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Type Valoration', $exception->getMessage());
        }
    }


    /**
    * @OA\Get(
    *       path="/api/v1/tests/type-valoration/{code}",
    *       tags={"Test/Valoration"},
    *       summary="Show type valoration  - Ver los datos de un tipo de valoracion",
    *       operationId="show-type-valoration",
    *       description="Return data to type valoration  - Retorna los datos de un tipo de valoracion",
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

            $typeValoration = $this->typeValorationRepository->findOneBy(["code" => $code]);

            if(!$typeValoration) {
                return $this->sendError("Error", "Type Valoration not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($typeValoration, 'Type Valoration information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Type Valoration', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/type-valoration/{code}",
    *       tags={"Test/Valoration"},
    *       summary="Edit type valoration  - Editar tipo de valoracion",
    *       operationId="type-valoration-edit",
    *       description="Edit a test-type  - Edita un tipo de valoracion",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTypeValorationRequest")
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
     * @param UpdateTypeValorationRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTypeValorationRequest $request, $code)
    {
        try {

            $typeValoration = $this->typeValorationRepository->findOneBy(["code" => $code]);

            if(!$typeValoration) {
                return $this->sendError("Error", "Type Valoration not found", Response::HTTP_NOT_FOUND);
            }

            $typeValorationUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->typeValorationRepository->update($typeValorationUpdate, $typeValoration);

             return $this->sendResponse($updated, 'Type Valoration data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Test Type Valoration', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/type-valoration/{code}",
    *       tags={"Test/Valoration"},
    *       summary="Delete type valoration  - Elimina un tipo de valoración",
    *       operationId="type-valoration-delete",
    *       description="Delete a type valoration - Elimina un tipo de valoración",
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

            $typeValoration = $this->typeValorationRepository->findOneBy(["code" => $code]);

            if(!$typeValoration) {
                return $this->sendError("Error", "Type Valoration not found", Response::HTTP_NOT_FOUND);
            }

            return $this->typeValorationRepository->delete($typeValoration->id) 
            ? $this->sendResponse(NULL, 'Type Valoration deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Type  Valoration Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Type Valoration', $exception->getMessage());
        }
    }
}
