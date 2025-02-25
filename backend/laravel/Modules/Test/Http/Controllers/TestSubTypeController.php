<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreTestSubTypeRequest;
use Modules\Test\Http\Requests\UpdateTestSubTypeRequest;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;

class TestSubTypeController extends BaseController
{
    /**
     * @var $testSubTypeRepository
     */
    protected $testSubTypeRepository;

    /**
     * @var $testSubTypeRepository
     */
    protected $testTypeRepository;

    public function __construct(
        TestSubTypeRepositoryInterface $testSubTypeRepository,
        TestTypeRepositoryInterface  $testTypeRepository
    )
    {
        $this->testSubTypeRepository = $testSubTypeRepository;
        $this->testTypeRepository = $testTypeRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/test-sub-type",
    *       tags={"Test"},
    *       summary="Get list test sub type  - Lista de sub tipos de test",
    *       operationId="list-test-sub-type",
    *       description="Return data list test-sub-type - Retorna el listado de sub tipos de test",
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
     * Display a listing of Test Sub Types.
     * @return Response
     */
    public function index()
    {
        $testSubType = $this->testSubTypeRepository->findAllImage();

        return $this->sendResponse($testSubType, 'List of Test Sub Type');
    }

     /**
    * @OA\Get(
    *       path="/api/v1/tests/test-sub-type/{test_type_code}/type",
    *       tags={"Test"},
    *       summary="Get list test sub type by type  - Lista de sub tipos de test por tipo",
    *       operationId="list-test-sub-type-type",
    *       description="Return data list test sub type by type - Retorna el listado de sub tipos de test por tipo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/test_type_code" ),
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
     * Display a listing of Test Sub Types.
     * @return Response
     */
    public function listBytype($test_type_code)
    {
        $testType = $this->testTypeRepository->findOneBy(["code" => $test_type_code]);

        if(!$testType) {
            return $this->sendError("Error", "Test Type not found", Response::HTTP_NOT_FOUND);
        }

        $testSubType = $this->testSubTypeRepository->findBy(["test_type_id" => $testType->id]);

        return $this->sendResponse($testSubType, 'List of Test Sub Type by type');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/test-sub-type",
    *       tags={"Test"},
    *       summary="Stored Test Sub Type - guardar sub tipo de test",
    *       operationId="/test-sub-type-store",
    *       description="Store a new sub type test - Guarda un nuevo sub tipo de test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreTestSubTypeRequest")
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
     * @param StoreTestSubTypeRequest $request
     * @return Response
     */
    public function store(StoreTestSubTypeRequest $request)
    {
        try {

            $testSubTypeCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'test_type_id' => $request->test_type_id,
                'code' => $request->code,
                
            ];

            $testSubType = $this->testSubTypeRepository->create($testSubTypeCreate);

            return $this->sendResponse($testSubType, 'Test Sub Type stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Test Sub Type', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/test-sub-type/{code}",
    *       tags={"Test"},
    *       summary="Show Test Sub Type  - Ver los datos de un sub tipo de test",
    *       operationId="show-test-sub-type",
    *       description="Return data to Test Sub Type  - Retorna los datos de un sub tipo de test",
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

            $testSubType = $this->testSubTypeRepository->findOneBy(["code" => $code]);

            if(!$testSubType) {
                return $this->sendError("Error", "Test Sub Type not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($testSubType, 'Test Sub Type information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test Sub Type ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/test-sub-type/{code}",
    *       tags={"Test"},
    *       summary="Edit Test Sub Type  - Editar sub tipo de test",
    *       operationId="test-sub-type-edit",
    *       description="Edit a test-sub-type  - Edita un sub tipo de test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTestSubTypeRequest")
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
     * @param UpdateTestSubTypeRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTestSubTypeRequest $request, $code)
    {
        try {

            $testSubType = $this->testSubTypeRepository->findOneBy(["code" => $code]);

            if(!$testSubType) {
                return $this->sendError("Error", "Test Sub Type not found", Response::HTTP_NOT_FOUND);
            }

            $testSubTypeUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'test_type_id' => $request->test_type_id,
            ];

             $updated = $this->testSubTypeRepository->update($testSubTypeUpdate, $testSubType);

             return $this->sendResponse($updated, 'Test Sub Type data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Test Sub Type', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/test-sub-type/{code}",
    *       tags={"Test"},
    *       summary="Delete Test Sub Type  - Elimina un sub tipo de test",
    *       operationId="test-sub-type-delete",
    *       description="Delete a Test Sub Type - Elimina un sub tipo de test",
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

            $testSubType = $this->testSubTypeRepository->findOneBy(["code" => $code]);

            if(!$testSubType) {
                return $this->sendError("Error", "Test Sub Type not found", Response::HTTP_NOT_FOUND);
            }

            return $this->testSubTypeRepository->delete($testSubType->id) 
            ? $this->sendResponse(NULL, 'Test Sub Type deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Test Sub Type Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Test Sub Type', $exception->getMessage());
        }
    }
}
