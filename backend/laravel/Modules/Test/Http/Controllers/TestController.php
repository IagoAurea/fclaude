<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Test\Services\TestService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreTestRequest;
use Modules\Test\Http\Requests\UpdateTestRequest;
use Modules\Generality\Services\ResourceService;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class TestController extends BaseController
{
    use ResourceTrait;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $testSubTypeRepository
     */
    protected $testSubTypeRepository;

    /**
     * @var $testSubTypeRepository
     */
    protected $testTypeRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $testService
     */
    protected $testService;


    public function __construct(
        TestRepositoryInterface $testRepository,
        TestSubTypeRepositoryInterface $testSubTypeRepository,
        TestTypeRepositoryInterface  $testTypeRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService,
        TestService $testService
    )
    {
        $this->testRepository = $testRepository;
        $this->testSubTypeRepository = $testSubTypeRepository;
        $this->testTypeRepository = $testTypeRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
        $this->testService = $testService;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests",
    *       tags={"Test"},
    *       summary="Get list tests  - Lista de test",
    *       operationId="list-test",
    *       description="Return data list tests - Retorna el listado de tests",
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
     * Display a listing of question.
     * @return Response
     */
    public function index(Request $request)
    {
        $tests = $this->testRepository->findAllImage($request);

        return $this->sendResponse($tests, 'List of tests');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/{test_type_code}/type",
    *       tags={"Test"},
    *       summary="Get list tests by type  - Lista de test por tipo",
    *       operationId="list-test-type",
    *       description="Return data list tests by type - Retorna el listado de tests por tipo",
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
     * Display a listing of question.
     * @return Response
     */
    public function listByType($test_type_code)
    {
        $testType = $this->testTypeRepository->findOneBy(["code" => $test_type_code]);

        if (!$testType) {
            return $this->sendError("Error", "Test Type not found", Response::HTTP_NOT_FOUND);
        }

        $test = $this->testRepository->findBy(["test_type_id" => $testType->id]);

        return $this->sendResponse($test, 'List of Test by type');
    }

     /**
    * @OA\Get(
    *       path="/api/v1/tests/{test_sub_type_code}/sub-type",
    *       tags={"Test"},
    *       summary="Get list tests by sub type  - Lista de test por sub tipo",
    *       operationId="list-test-sub-type",
    *       description="Return data list tests by sub type - Retorna el listado de tests por sub tipo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/test_sub_type_code" ),
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
     * Display a listing of question.
     * @return Response
     */
    public function listBySubType($test_sub_type_code)
    {
        $testSubType = $this->testSubTypeRepository->findOneBy(["code" => $test_sub_type_code]);

        if (!$testSubType) {
            return $this->sendError("Error", "Test Sub Type not found", Response::HTTP_NOT_FOUND);
        }

        $test = $this->testRepository->findBy(["test_sub_type_id" => $testSubType->id]);

        return $this->sendResponse($test, 'List of Test by Sub type');
    }
    
    /**
    * @OA\Post(
    *       path="/api/v1/tests",
    *       tags={"Test"},
    *       summary="Stored Test - Guardar Test",
    *       operationId="test-store",
    *       description="Store a new Test - Guarda un nuevo Test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreTestRequest")
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
     * @param StoreTestRequest $request
     * @return Response
     */
    public function store(StoreTestRequest $request)
    {
        try {

            $testCreate = [
                'es' => [
                    'name' => $request->name_spanish,
                    'description' => $request->description_spanish
                ],
                'en' => [
                    'name' => $request->name_english,
                    'description' => $request->description_english
                ],
                'test_type_id' => $request->test_type_id,
                'type_valoration_code' => $request->type_valoration_code,
                'value' => $request->value,
                'sport_id' => $request->sport_id,
            ];

            if ($request->image) {
                $dataResource = $this->uploadResource('/test', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $testCreate['image_id'] = $resource->id;
                }
            }

            $test = $this->testRepository->create($testCreate);

            $questions = $this->testService->createQuestions($request->associate_questions,$test->id);

            if (!$questions['success']) {
                return $this->sendError('Error by Create Questions',$questions['message']);
            }

            if ($request->configurations) {
                $configurations = $this->testService->createConfigurations($request->configurations,$test->id);

                if (!$configurations['success']) {
                    return $this->sendError('Error by Configurate test',$configurations['message']);
                }
    
            }
           
            if ($request->table) {
                $table = $this->testService->createTable($request->table,$test->id);

                if (!$table['success']) {
                    return $this->sendError('Error by Configurate test table',$table['message']);
                }
            }
            return $this->sendResponse($test, 'Test stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Test', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/{code}",
    *       tags={"Test"},
    *       summary="Show Test  - Ver los datos de un Test",
    *       operationId="show-test",
    *       description="Return data to Test  - Retorna los datos de un Test",
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
    public function show($code, Request $request)
    {
        try {

            $test = $this->testRepository->findOneBy(["code" => $code]);

            if (!$test) {
                return $this->sendError("Error", "Test not found", Response::HTTP_NOT_FOUND);
            }

            $test = $this->testRepository->findTestAll($test->id, $request->get('_locale'));

            return $this->sendResponse($test, 'Test information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Test', $exception->getMessage());
        }
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/{code}",
    *       tags={"Test"},
    *       summary="Edit Test  - Editar Test",
    *       operationId="test-edit",
    *       description="Edit a Test  - Edita un Test",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/UpdateTestRequest")
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
     * @param UpdateTestRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTestRequest  $request, $code)
    {
        try {

            $test = $this->testRepository->findOneBy(["code" => $code]);

            if (!$test) {
                return $this->sendError("Error", "Test not found", Response::HTTP_NOT_FOUND);
            }

            $testUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'test_type_id' => $request->test_type_id,
                'type_valoration_code' => $request->type_valoration_code,
                'value' => $request->value,
            ];

            if ($request->image) {
                $dataResource = $this->uploadResource('/test', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $testUpdate['image_id'] = $resource->id;
                }
            }
            if ($request->image && $test->image_id)
                $this->resourceService->deleteResourceData($test->image_id);

            $updated = $this->testRepository->update($testUpdate,["id" => $test->id]);

             return $this->sendResponse($updated, 'Test data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Test', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/{code}",
    *       tags={"Test"},
    *       summary="Delete Test  - Elimina un Test",
    *       operationId="test-delete",
    *       description="Delete a Test - Elimina un Test",
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

            $test = $this->testRepository->findOneBy(["code" => $code]);

            if (!$test) {
                return $this->sendError("Error", "Test not found", Response::HTTP_NOT_FOUND);
            }

            return $this->testRepository->delete($test->id)
            ? $this->sendResponse(NULL, 'Test deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Test Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Test', $exception->getMessage());
        }
    }
}
