<?php

namespace Modules\Nutrition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Http\Requests\StoreSupplementRequest;
use Modules\Nutrition\Http\Requests\UpdateSupplementRequest;
use Modules\Nutrition\Repositories\Interfaces\SupplementRepositoryInterface;

class SupplementController extends BaseController
{
   /**
     * @var $supplementRepository
     */
    protected $supplementRepository;


    public function __construct(
        SupplementRepositoryInterface $supplementRepository
    )
    {
        $this->supplementRepository = $supplementRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/supplements",
    *       tags={"Nutrition"},
    *       summary="Get list supplements - Lista de suplementos",
    *       operationId="list-supplement",
    *       description="Return data list supplement  - Retorna listado de suplementos",
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
     * Display a listing of supplements.
     * @return Response
     */
    public function index()
    {
        $supplements = $this->supplementRepository->findAllTranslated();

        return $this->sendResponse($supplements, 'List Supplements');
    }

     /**
    * @OA\Post(
    *       path="/api/v1/nutrition/supplements",
    *       tags={"Nutrition"},
    *       summary="Stored Supplement - guardar un nuevo suplemento ",
    *       operationId="supplement-store",
    *       description="Store a new supplement - Guarda un nuevo suplemento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreSupplementRequest")
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
     * @param Request $request
     * @return Response
     */
    public function store(StoreSupplementRequest $request)
    {
        try {

            $suplementCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $supplement = $this->supplementRepository->create($suplementCreate);

            return $this->sendResponse($supplement, 'Supplement stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/supplements/{supplement_id}",
    *       tags={"Nutrition"},
    *       summary="Show supplement - Ver los datos de un suplemento",
    *       operationId="show-supplement",
    *       description="Return data to supplement  - Retorna los datos de un suplemento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/supplement_id" ),
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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $supplemment = $this->supplementRepository->find($id);

            return $this->sendResponse($supplemment, 'Supplement information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving supplement', $exception->getMessage());
        }
    }

    /**
    * @OA\Post(
    *       path="/api/v1/nutrition/supplements/{supplement_id}",
    *       tags={"Nutrition"},
    *       summary="Edit supplement - Editar un suplemento",
    *       operationId="supplement-edit",
    *       description="Edit a supplement - Edita un suplemento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/supplement_id" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateSupplementRequest")
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
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateSupplementRequest $request, $id)
    {
        try {
            $supplement = $this->supplementRepository->find($id);
            $suplementUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->supplementRepository->update($suplementUpdate, $supplement);

             return $this->sendResponse($updated, 'Supplement data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating supplement', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/nutrition/supplements/{supplement_id}",
    *       tags={"Nutrition"},
    *       summary="Delete supplement- Elimina un suplemento",
    *       operationId="supplement-delete",
    *       description="Delete a supplement - Elimina un suplemento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/supplement_id" ),
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
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            return $this->supplementRepository->delete($id)
            ? $this->sendResponse(null, 'Supplement deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Supplement Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Supplement', $exception->getMessage());
        }
    }
}
