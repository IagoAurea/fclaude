<?php

namespace Modules\Injury\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Http\Requests\StoreCurrentSituationRequest;
use Modules\Injury\Http\Requests\UpdateCurrentSituationRequest;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;

class CurrentSituationController extends BaseController
{
    /**
     * @var $situationRepository
     */
    protected $situationRepository;

    public function __construct(
        CurrentSituationRepositoryInterface $situationRepository
    )
    {
        $this->situationRepository = $situationRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/injuries/current-situation",
    *       tags={"Injury"},
    *       summary="Get list current situation - Lista de situación actual",
    *       operationId="list-current-situation",
    *       description="Return data list  current situation  - Retorna listado de situación actual",
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
     * Display a listing of situation.
     * @return Response
     */
    public function index()
    {
        $situation = $this->situationRepository->findAllTranslated();

        return $this->sendResponse($situation, 'List of situation');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/injuries/current-situation",
    *       tags={"Injury"},
    *       summary="Stored Current Situation - guardar nuevo estado ",
    *       operationId="current-situation-store",
    *       description="Store a new current situation - Guarda un  nuevo estado de situación actual",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreCurrentSituationRequest")
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
     * @param StoreCurrentSituationRequest $request
     * @return Response
     */
    public function store(StoreCurrentSituationRequest $request)
    {
        try {

            $situationCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'color'          => $request->color,
                'min_percentage' => $request->min_percentage,
                'max_percentage' => $request->max_percentage,
                'type'           => 1,
            ];

            $situation = $this->situationRepository->create($situationCreate);

            return $this->sendResponse($situation, 'Current Situation stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Current Situation', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/injuries/current-situation/{code}",
    *       tags={"Injury"},
    *       summary="Show Current Situation - Ver los datos de un estatus de situación actual",
    *       operationId="show-current-situation",
    *       description="Return data to current situation  - Retorna los datos de un estatus de situación",
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

            $situation = $this->situationRepository->findOneBy(["code" => $code]);

            if(!$situation) {
                return $this->sendError("Error", "Current Situation not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($situation, 'Current Situation information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Current Situation ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/injuries/current-situation/{code}",
    *       tags={"Injury"},
    *       summary="Edit current situation - Editar un estado de situacion actual",
    *       operationId="current-situation-edit",
    *       description="Edit a current situation - Edita un estado de situacion actual",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateCurrentSituationRequest")
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
     * @param UpdateCurrentSituationRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateCurrentSituationRequest $request, $code)
    {
        try {

            $situation = $this->situationRepository->findOneBy(["code" => $code]);

            if(!$situation) {
                return $this->sendError("Error", "Current Situation not found", Response::HTTP_NOT_FOUND);
            }

            $situationUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'color'          => $request->color,
                'min_percentage' => $request->min_percentage,
                'max_percentage' => $request->max_percentage,
                'type'           => 1,  
            ];


             $updated = $this->situationRepository->update($situationUpdate, $situation);

             return $this->sendResponse($updated, 'Current Situation data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Current Situation', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/injuries/current-situation/{code}",
    *       tags={"Injury"},
    *       summary="Delete current situation- Elimina un estado de situación actual",
    *       operationId="current-situation-delete",
    *       description="Delete a current situation - Elimina un estado de situación actual",
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

            $situation = $this->situationRepository->findOneBy(["code" => $code]);

            if(!$situation) {
                return $this->sendError("Error", "Current Situation not found", Response::HTTP_NOT_FOUND);
            }

            $return = $this->situationRepository->delete($situation->id) 
            ? $this->sendResponse(NULL, 'Current Situation deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Current Situation Not Existing');

            return $return; 
            
        } catch (Exception $exception) {
        return $this->sendError('Error by deleting Current Situation', $exception->getMessage());
        }
    }
}
