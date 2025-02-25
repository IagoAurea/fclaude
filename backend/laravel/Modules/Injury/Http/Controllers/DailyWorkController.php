<?php

namespace Modules\Injury\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Injury\Http\Requests\StoreDailyWorkRequest;
use Modules\Injury\Http\Requests\UpdateDailyWorkRequest;
use Modules\Injury\Services\DailyWorkService; 
use Modules\Injury\Repositories\Interfaces\DailyWorkRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;

class DailyWorkController extends BaseController
{
    /**
     * @var $dailyWorkRepository
     */
    protected $dailyWorkRepository;

    /**
     * @var $dailyWorkService
     */
    protected $dailyWorkService;
    

    /**
     * @var $rdfRepository
     */
    protected $rdfRepository;

    public function __construct(
        DailyWorkRepositoryInterface $dailyWorkRepository,
        InjuryRfdRepositoryInterface $rdfRepository,
        DailyWorkService $dailyWorkService
    )
    {
        $this->dailyWorkRepository = $dailyWorkRepository;
        $this->rdfRepository = $rdfRepository;
        $this->dailyWorkService = $dailyWorkService; 
    }

    /**
    * @OA\Get(
    *       path="/api/v1/injuries/daily-works/{code}/rfd",
    *       tags={"Injury/DailyWork"},
    *       summary="Get list daily works by rfd code- Lista de trabajos diarios por rfd",
    *       operationId="list-daily-works",
    *       description="Return data list daily works by rfd code  - Retorna listado de trabajos diarios por rfd",
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
     * Display a listing of daily Work.
     * @return Response
     */
    public function index($code)
    {
        $rdf = $this->rdfRepository->findOneBy(["code" => $code]);

        if(!$rdf) {
            return $this->sendError("Error", "Rdf not found", Response::HTTP_NOT_FOUND);
        }

        $dailyWork = $this->dailyWorkRepository->findAllByRdf($rdf->id);

        return $this->sendResponse($dailyWork, 'List of Daily Work');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/injuries/daily-works",
    *       tags={"Injury/DailyWork"},
    *       summary="Stored daily works - Guardar nuevo trabajo diario ",
    *       operationId="stored-daily-works",
    *       description="Store a new daily works - Guarda un nuevo trabajo diario",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreDailyWorkRequest")
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
     * @param StoreDailyWorkRequest $request
     * @return Response
     */
    public function store(StoreDailyWorkRequest $request)
    {
        try {

            $dailyWorkCalculate = $this->dailyWorkService->calculateDailyWork($request->all()); 

            if (!$dailyWorkCalculate['success']) {
                return $this->sendError('Error by calculate Values',$dailyWorkCalculate['message']);
            } 

            $request['training_load'] =$dailyWorkCalculate['data']['training_load'];
            $request['monotony'] = $dailyWorkCalculate['data']['monotony'];
            $request['training_strain'] = $dailyWorkCalculate['data']['training_strain'];

            $dailyWork = $this->dailyWorkRepository->create($request->all());

            return $this->sendResponse($dailyWork, 'Daily Work stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Daily Work', $exception->getMessage());
        }
    }

     /**
    * @OA\Get(
    *       path="/api/v1/injuries/daily-works/{code}",
    *       tags={"Injury/DailyWork"},
    *       summary="Show daily work - Ver los datos de un trabajo diario",
    *       operationId="show-daily-works",
    *       description="Return data to daily work  - Retorna los datos de un trabajo diario",
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
            $dailyWork = $this->dailyWorkRepository->findOneBy(["code" => $code]);

            if(!$dailyWork) {
                return $this->sendError("Error", "Daily Work not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($dailyWork, 'Daily Work information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Daily Work ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/injuries/daily-works/{code}",
    *       tags={"Injury/DailyWork"},
    *       summary="Edit daily work - Editar un trabajo diario",
    *       operationId="daily-works-edit",
    *       description="Edit a daily work - Edita un trabajo diario",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateDailyWorkRequest")
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
     * @param UpdateDailyWorkRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateDailyWorkRequest $request, $code)
    {
        try {
            $dailyWork = $this->dailyWorkRepository->findOneBy(["code" => $code]);

            if(!$dailyWork) {
                return $this->sendError("Error", "Daily Work not found", Response::HTTP_NOT_FOUND);
            }

             $updated = $this->dailyWorkRepository->update($request->all(), $dailyWork);

             return $this->sendResponse($updated, 'Daily Work  data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Daily Work', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/injuries/daily-works/{code}",
    *       tags={"Injury/DailyWork"},
    *       summary="Delete daily work - Elimina un trabajo diario",
    *       operationId="daily-works-delete",
    *       description="Delete a daily work - Elimina un trabajo diario",
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

            $dailyWork = $this->dailyWorkRepository->findOneBy(["code" => $code]);

            if(!$dailyWork) {
                return $this->sendError("Error", "Daily Work not found", Response::HTTP_NOT_FOUND);
            }

            return $this->dailyWorkRepository->delete($dailyWork->id) 
            ? $this->sendResponse(NULL, 'Daily Work deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Daily Work Not Existing');

        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Daily Work', $exception->getMessage());
        }
    }
}
