<?php

namespace Modules\Injury\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Http\Requests\StorePhaseRequest;
use Modules\Injury\Http\Requests\UpdatePhaseRequest;
use Modules\Injury\Repositories\Interfaces\PhaseRepositoryInterface;
use Exception;

class PhaseController extends BaseController
{
    /**
     * @var $phaseRepository
     */
    protected $phaseRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(PhaseRepositoryInterface $phaseRepository)
    {
        $this->phaseRepository = $phaseRepository;
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/phases",
     *       tags={"Injury/Phase"},
     *       summary="Get list phases - Lista de Fases",
     *       operationId="list-phases",
     *       description="Return data list phases  - Retorna listado de Fases",
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
     * Display a listing of phases.
     * @return Response
     */
    public function index()
    {
        $phases = $this->phaseRepository->findAllTranslated();

        return $this->sendResponse($phases, 'List of Phases');
    }

    /**
     * @OA\Post(
     *       path="/api/v1/injuries/phases",
     *       tags={"Injury/Phase"},
     *       summary="Stored phase - Guardar nueva Fase ",
     *       operationId="stored-phase",
     *       description="Store a new phase - Guarda una nueva fase",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StorePhaseRequest")
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
     * @param StorePhaseRequest $request
     * @return Response
     */
    public function store(StorePhaseRequest $request)
    {
        try {

            $phaseCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'test_code' => $request->test_code,
                'percentage_value' => $request->percentage_value,
                'min_percentage_pass' => $request->min_percentage_pass
            ];

            $phase = $this->phaseRepository->create($phaseCreate);

            return $this->sendResponse($phase, 'Phase stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Phase', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/injuries/phases/{code}",
     *       tags={"Injury/Phase"},
     *       summary="Show phase - Ver los datos de una fase",
     *       operationId="show-phase",
     *       description="Return data to phase  - Retorna los datos de una fase",
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

            $phase = $this->phaseRepository->findOneBy(["code" => $code]);

            if (!$phase) {
                return $this->sendError("Error", "Phase not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($phase, 'Phase information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Phase ', $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *       path="/api/v1/injuries/phases/{code}",
     *       tags={"Injury/Phase"},
     *       summary="Edit phase - Editar una fase",
     *       operationId="phases-edit",
     *       description="Edit a phase - Edita una fase",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/code" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/UpdatePhaseRequest")
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
     * @param UpdatePhaseRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdatePhaseRequest $request, $code)
    {
        try {

            $phase = $this->phaseRepository->findOneBy(["code" => $code]);

            if (!$phase) {
                return $this->sendError("Error", "Phase not found", Response::HTTP_NOT_FOUND);
            }

            $phaseUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'test_code' => $request->test_code,
                'percentage_value' => $request->percentage_value,
                'min_percentage_pass' => $request->min_percentage_pass
            ];


            $updated = $this->phaseRepository->update($phaseUpdate, $phase);

            return $this->sendResponse($updated, 'Phase data updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating Phase', $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *       path="/api/v1/injuries/phases/{code}",
     *       tags={"Injury/Phase"},
     *       summary="Delete phase - Elimina una fase",
     *       operationId="phases-delete",
     *       description="Delete a phase - Elimina una fase",
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

            $phase = $this->phaseRepository->findOneBy(["code" => $code]);

            if (!$phase) {
                return $this->sendError("Error", "Phase not found", Response::HTTP_NOT_FOUND);
            }

            return $this->phaseRepository->delete($phase->id)
                ? $this->sendResponse(NULL, 'Phase deleted', Response::HTTP_ACCEPTED)
                : $this->sendError('Phase Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Phase', $exception->getMessage());
        }
    }
}
