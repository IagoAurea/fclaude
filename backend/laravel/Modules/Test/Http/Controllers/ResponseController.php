<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreResponseRequest;
use Modules\Test\Http\Requests\UpdateResponseRequest;
use Modules\Test\Repositories\Interfaces\ResponseRepositoryInterface;

class ResponseController extends BaseController
{
   /**
     * @var $responseRepository
     */
    protected $responseRepository;


    public function __construct(ResponseRepositoryInterface $responseRepository)
    {
        $this->responseRepository = $responseRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/responses",
    *       tags={"Test"},
    *       summary="Get list responses  - Lista de respuestas",
    *       operationId="list-responses",
    *       description="Return data list responses - Retorna el listado de respuestas",
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
     * Display a listing of responses.
     * @return Response
     */
    public function index()
    {
        $response = $this->responseRepository->findAllTranslated();

        return $this->sendResponse($response, 'List of Response');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/responses",
    *       tags={"Test"},
    *       summary="Stored response - Guardar respuesta",
    *       operationId="responses-store",
    *       description="Store a new responses - Guarda una nueva respuesta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreResponseRequest")
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
     * @param StoreResponseRequest $request
     * @return Response
     */
    public function store(StoreResponseRequest $request)
    {
        try {
            $responseCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'tooltick' => $request->tooltick
                
            ];

            $response = $this->responseRepository->create($responseCreate);

            return $this->sendResponse($response, 'Response stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Response', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/responses/{code}",
    *       tags={"Test"},
    *       summary="Show Response  - Ver los datos de una Respuesta",
    *       operationId="show-response",
    *       description="Return data to responses  - Retorna los datos de una Respuesta",
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
            $response = $this->responseRepository->findOneBy(["code" => $code]);

            if(!$response) {
                return $this->sendError("Error", "Response not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($response, 'Response information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Response', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/responses/{code}",
    *       tags={"Test"},
    *       summary="Edit Response  - Editar respuesta",
    *       operationId="response-edit",
    *       description="Edit a response  - Edita una respuesta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateResponseRequest")
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
     * @param UpdateResponseRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateResponseRequest  $request, $code)
    {
        try {
            $response = $this->responseRepository->findOneBy(["code" => $code]);

            if(!$response) {
                return $this->sendError("Error", "Response not found", Response::HTTP_NOT_FOUND);
            }

            $responseUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'tooltick' => $request->tooltick
            ];

             $updated = $this->responseRepository->update($responseUpdate, $response);

             return $this->sendResponse($updated, 'Response data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Response', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/responses/{code}",
    *       tags={"Test"},
    *       summary="Delete Response  - Elimina una respuesta",
    *       operationId="response-delete",
    *       description="Delete a Response - Elimina una respuesta",
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
            $response = $this->responseRepository->findOneBy(["code" => $code]);

            if(!$response) {
                return $this->sendError("Error", "Response not found", Response::HTTP_NOT_FOUND);
            }

            return $this->responseRepository->delete($response->id)
            ? $this->sendResponse(null, 'Response deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Response Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Response', $exception->getMessage());
        }
    }
}
