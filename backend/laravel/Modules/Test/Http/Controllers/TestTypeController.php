<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreTestTypeRequest;
use Modules\Test\Http\Requests\UpdateTestTypeRequest;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;

class TestTypeController extends BaseController
{
   /**
     * @var $testTypeRepository
     */
    protected $testTypeRepository;


    public function __construct(
        TestTypeRepositoryInterface $testTypeRepository
    )
    {
        $this->testTypeRepository = $testTypeRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/test-type",
    *       tags={"Test"},
    *       summary="Get list test-type  - Lista de tipos de test",
    *       operationId="list-test-type",
    *       description="Return data list test-type - Retorna el listado de tipos de test",
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
     * Display a listing of test types.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->only([
            'classification'
        ]);

        $testType = $this->testTypeRepository->findAllImage($params);

        return $this->sendResponse($testType, 'List of Test Type');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/test-type",
    *       tags={"Test"},
    *       summary="Stored Test Type - guardar tipo de test",
    *       operationId="/test-type-store",
    *       description="Store a new question - Guarda un nuevo tipo de test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreTestTypeRequest")
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
     * @param StoreTestTypeRequest $request
     * @return Response
     */
    public function store(StoreTestTypeRequest $request)
    {
        try {

            $testTypeCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'classification' => $request->classification
                
            ];

            $testType = $this->testTypeRepository->create($testTypeCreate);

            return $this->sendResponse($testType, 'Test Type stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Test Type', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/test-type/{code}",
    *       tags={"Test"},
    *       summary="Show test type  - Ver los datos de un tipo de test",
    *       operationId="show-test-type",
    *       description="Return data to test type  - Retorna los datos de un tipo de test",
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

            $testType = $this->testTypeRepository->findOneBy(["code" => $code]);

            if(!$testType) {
                return $this->sendError("Error", "Test Type not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($testType, 'Test Type information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test Type ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/test-type/{code}",
    *       tags={"Test"},
    *       summary="Edit test type  - Editar tipo de test",
    *       operationId="test-type-edit",
    *       description="Edit a test-type  - Edita un tipo de test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTestTypeRequest")
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
     * @param UpdateTestTypeRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTestTypeRequest $request, $code)
    {
        try {

            $testType = $this->testTypeRepository->findOneBy(["code" => $code]);

            if(!$testType) {
                return $this->sendError("Error", "Test Type not found", Response::HTTP_NOT_FOUND);
            }

            $testTypeUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'classification' => $request->classification
            ];

             $updated = $this->testTypeRepository->update($testTypeUpdate, $testType);

             return $this->sendResponse($updated, 'Test Type data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Test Type', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/test-type/{code}",
    *       tags={"Test"},
    *       summary="Delete Test Type  - Elimina un tipo de test",
    *       operationId="test-type-delete",
    *       description="Delete a Test Type - Elimina un tipo de test",
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

            $testType = $this->testTypeRepository->findOneBy(["code" => $code]);

            if(!$testType) {
                return $this->sendError("Error", "Test Type not found", Response::HTTP_NOT_FOUND);
            }

            return $this->testTypeRepository->delete($testType->id) 
            ? $this->sendResponse(NULL, 'Test Type deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Test Type Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Test Type', $exception->getMessage());
        }
    }
}
