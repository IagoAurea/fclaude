<?php

namespace Modules\Injury\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Http\Requests\StoreReinstatementCriteriaRequest;
use Modules\Injury\Http\Requests\UpdateReinstatementCriteriaRequest;
use Modules\Injury\Repositories\Interfaces\ReinstatementCriteriaRepositoryInterface;


class ReinstatementCriteriaController extends BaseController
{


    /**
     * @var $criteriaRepository
     */
    protected $criteriaRepository;

    public function __construct(
        ReinstatementCriteriaRepositoryInterface $criteriaRepository
    )
    {
        $this->criteriaRepository = $criteriaRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/injuries/reinstatement-criteria",
    *       tags={"Injury/ReinstatementCriteria"},
    *       summary="Get list reinstatement criteria - Lista de criterios de reinstalación",
    *       operationId="list-reinstatement-criteria",
    *       description="Return data reinstatement criteria  - Retorna listado de criterios de reinstalación",
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
     * Display a listing of criteria.
     * @return Response
     */
    public function index()
    {
        $criteria = $this->criteriaRepository->findAllTranslated();

        return $this->sendResponse($criteria, 'List of Reinstatement Criteria');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/injuries/reinstatement-criteria",
    *       tags={"Injury/ReinstatementCriteria"},
    *       summary="Stored  reinstatement criterion - Guardar nuevo criterios de reinstalación ",
    *       operationId="stored-reinstatement-criteria",
    *       description="Store a reinstatement criterion - Guarda un nuevo criterios de reinstalación",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreReinstatementCriteriaRequest")
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
     * @param StoreReinstatementCriteriaRequest $request
     * @return Response
     */
    public function store(StoreReinstatementCriteriaRequest $request)
    {
        try {

            $criteriaCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $criteria = $this->criteriaRepository->create($criteriaCreate);

            return $this->sendResponse($criteria, 'Reinstatement Criteria stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Reinstatement Criteria', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/injuries/reinstatement-criteria/{code}",
    *       tags={"Injury/ReinstatementCriteria"},
    *       summary="Show reinstatement criteria - Ver los datos de un criterio de reinstalación",
    *       operationId="show-reinstatement-criteria",
    *       description="Return data to reinstatement criteria  - Retorna los datos de un criterio de reinstalación",
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

            $criteria = $this->criteriaRepository->findOneBy(["code" => $code]);

            if(!$criteria) {
                return $this->sendError("Error", "Reinstatement Criterianot found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($criteria, 'Reinstatement Criteria information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Reinstatement Criteria ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/injuries/reinstatement-criteria/{code}",
    *       tags={"Injury/ReinstatementCriteria"},
    *       summary="Edit reinstatement criteria - Editar un criterio de reinstalación",
    *       operationId="reinstatement-criteria-edit",
    *       description="Edit a reinstatement criteria - Edita un criterio de reinstalación",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateReinstatementCriteriaRequest")
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
     * @param UpdateReinstatementCriteriaRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateReinstatementCriteriaRequest $request, $code)
    {
        try {

            $criteria = $this->criteriaRepository->findOneBy(["code" => $code]);

            if(!$criteria) {
                return $this->sendError("Error", "Reinstatement Criteria not found", Response::HTTP_NOT_FOUND);
            }

            $criteriaUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];


             $updated = $this->criteriaRepository->update($criteriaUpdate, $criteria);

             return $this->sendResponse($updated, 'Reinstatement Criteria data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Reinstatement Criteria', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/injuries/reinstatement-criteria/{code}",
    *       tags={"Injury/ReinstatementCriteria"},
    *       summary="Delete reinstatement criteria - Elimina un criterio de reinstalación",
    *       operationId="reinstatement-criteria-delete",
    *       description="Delete a reinstatement-criteria - Elimina una criterio de reinstalación",
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

            $criteria = $this->criteriaRepository->findOneBy(["code" => $code]);

            if(!$criteria) {
                return $this->sendError("Error", "Reinstatement Criteria not found", Response::HTTP_NOT_FOUND);
            }

            $return = $this->criteriaRepository->delete($criteria->id) 
            ? $this->sendResponse(NULL, 'Reinstatement Criteria deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Reinstatement Criteria Not Existing');

            return $return; 
            
        } catch (Exception $exception) {
        return $this->sendError('Error by deleting Reinstatement Criteria', $exception->getMessage());
        }
    }

}
