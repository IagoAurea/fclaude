<?php

namespace Modules\Nutrition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Http\Requests\StoreDietRequest;
use Modules\Nutrition\Http\Requests\UpdateDietRequest;
use Modules\Nutrition\Repositories\Interfaces\DietRepositoryInterface;

class DietController extends BaseController
{
    /**
     * @var $dietRepository
     */
    protected $dietRepository;

    public function __construct(
        DietRepositoryInterface $dietRepository
    )
    {
        $this->dietRepository = $dietRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/diets",
    *       tags={"Nutrition"},
    *       summary="Get list diets - Lista de dietas",
    *       operationId="list-diet",
    *       description="Return data list diet  - Retorna listado de dietas",
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
     * Display a listing of diets.
     * @return Response
     */
    public function index()
    {
        $diets = $this->dietRepository->findAllTranslated();

        return $this->sendResponse($diets, 'List Diets');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/nutrition/diets",
    *       tags={"Nutrition"},
    *       summary="Stored Diet - guardar una nueva dieta ",
    *       operationId="diet-store",
    *       description="Store a new diet - Guarda una nueva dieta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreDietRequest")
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
    public function store(StoreDietRequest $request)
    {
        try {
            $dietCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $diet = $this->dietRepository->create($dietCreate);
            return $this->sendResponse($diet, 'Diet stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/nutrition/diets/{diet_id}",
    *       tags={"Nutrition"},
    *       summary="Show diet - Ver los datos de una dieta",
    *       operationId="show-diet",
    *       description="Return data to diet  - Retorna los datos de una dieta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/diet_id" ),
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
            $diet = $this->dietRepository->find($id);

            return $this->sendResponse($diet, 'Diet information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Diet', $exception->getMessage());
        }
    }

    /**
    * @OA\Post(
    *       path="/api/v1/nutrition/diets/{diet_id}",
    *       tags={"Nutrition"},
    *       summary="Edit diet - Editar una dieta",
    *       operationId="diet-edit",
    *       description="Edit a diet - Edita una dieta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/diet_id" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateDietRequest")
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
    public function update(UpdateDietRequest $request, $id)
    {
        try {
            $diet = $this->dietRepository->find($id);

            $dietUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

            $updated = $this->dietRepository->update($dietUpdate, $diet);
            
            return $this->sendResponse($updated, 'Diet data updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating diet', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/nutrition/diets/{diet_id}",
    *       tags={"Nutrition"},
    *       summary="Delete diet- Elimina una dieta",
    *       operationId="diet-delete",
    *       description="Delete a diet - Elimina una dieta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/diet_id" ),
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
         return $this->dietRepository->delete($id)
                   ?$this->sendResponse(null, 'Diet deleted', Response::HTTP_ACCEPTED)
                   :$this->sendError('Diet Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Diet', $exception->getMessage());
        }
    }
}
