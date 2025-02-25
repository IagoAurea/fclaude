<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Player\Http\Requests\StorePunctuationRequest;
use Modules\Player\Http\Requests\UpdatePunctuationRequest;
use Modules\Player\Repositories\Interfaces\PunctuationRepositoryInterface;

class PunctuationController extends BaseController
{
    /**
     * @var $punctuationRepository
     */
    protected $punctuationRepository;


    public function __construct(
        PunctuationRepositoryInterface $punctuationRepository
    )
    {
        $this->punctuationRepository = $punctuationRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/players/assessment/punctuation",
    *       tags={"Player"},
    *       summary="Get list punctuation  - Lista de puntuaciones",
    *       operationId="list-punctuation",
    *       description="Return data list punctuation - Retorna el listado de puntuaciones",
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
     * Display a listing of punctuation.
     * @return Response
     */
    public function index()
    {
        $punctuation = $this->punctuationRepository->findAllTranslated();

        return $this->sendResponse($punctuation, 'List of Punctuation');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/players/assessment/punctuation",
    *       tags={"Player"},
    *       summary="Stored Punctuation - guardar Puntuación",
    *       operationId="punctuation-store",
    *       description="Store a new punctuation - Guarda una nueva Puntuación",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StorePunctuationRequest")
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
     * @param StorePunctuationRequest $request
     * @return Response
     */
    public function store(StorePunctuationRequest $request)
    {
        try {

            $punctuationCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'value' => $request->value,
                'color' => $request->color
            ];

            $punctuation = $this->punctuationRepository->create($punctuationCreate);

            return $this->sendResponse($punctuation, 'Punctuation stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Punctuation', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/players/assessment/punctuation/{code}",
    *       tags={"Player"},
    *       summary="Show punctuation  - Ver los datos de un Puntuación",
    *       operationId="show-punctuation",
    *       description="Return data to punctuation  - Retorna los datos de un Puntuación",
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

            $punctuation = $this->punctuationRepository->findOneBy(["code" => $code]);

            if(!$punctuation) {
                return $this->sendError("Error", "Punctuation not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($punctuation, 'Punctuation information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Punctuation', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/players/assessment/punctuation/{code}",
    *       tags={"Player"},
    *       summary="Edit Puntuación  - Editar Puntuación",
    *       operationId="punctuation-edit",
    *       description="Edit a punctuation  - Edita un Puntuación",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdatePunctuationRequest")
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
     * @param UpdatePunctuationRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdatePunctuationRequest $request, $code)
    {
        try {

            $punctuation = $this->punctuationRepository->findOneBy(["code" => $code]);

            if(!$punctuation) {
                return $this->sendError("Error", "Punctuation not found", Response::HTTP_NOT_FOUND);
            }

            $punctuationUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'value' => $request->value,
                'color' => $request->color
            ];

             $updated = $this->punctuationRepository->update($punctuationUpdate, $punctuation);

             return $this->sendResponse($updated, 'Punctuation data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Punctuation', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/players/assessment/punctuation/{code}",
    *       tags={"Player"},
    *       summary="Delete Punctuation  - Elimina un Puntuación",
    *       operationId="punctuation-delete",
    *       description="Delete a Punctuation - Elimina un Puntuación",
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

            $punctuation = $this->punctuationRepository->findOneBy(["code" => $code]);

            if(!$punctuation) {
                return $this->sendError("Error", "Punctuation not found", Response::HTTP_NOT_FOUND);
            }

            $return = $this->punctuationRepository->delete($punctuation->id) 
            ? $this->sendResponse(NULL, 'Punctuation deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Punctuation Not Existing');

            return $return; 
            
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Punctuation', $exception->getMessage());
        }
    }

}
