<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreTrainingPeriodRequest;
use Modules\Training\Http\Requests\UpdateTrainingPeriodRequest;
use Modules\Training\Repositories\Interfaces\TrainingPeriodRepositoryInterface;

class TrainingPeriodController extends BaseController
{
    /**
     * @var $trainingPeriodRepository
     */
    protected $trainingPeriodRepository;


    public function __construct(
        TrainingPeriodRepositoryInterface $trainingPeriodRepository
    )
    {
        $this->trainingPeriodRepository = $trainingPeriodRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/training/training-periods",
    *       tags={"ExerciseSession"},
    *       summary="Get list training periods - Lista de periodos de entrenamiento",
    *       operationId="list-training-periods",
    *       description="Return data list training periods  - Retorna listado de periodos de entrenamiento",
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
     * Display a listing of Training Period.
     * @return Response
     */
    public function index()
    {
        $trainingPeriod = $this->trainingPeriodRepository->findAllTranslated();

        return $this->sendResponse($trainingPeriod, 'List of Training Period');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/training-periods",
    *       tags={"ExerciseSession"},
    *       summary="Stored Training Period - guardar un nuevo Periodo de entrenamiento ",
    *       operationId="training-periods-store",
    *       description="Store a new training period - Guarda un nuevo Periodo de entrenamiento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreTrainingPeriodRequest")
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
     * @param StoreTrainingPeriodRequest $request
     * @return Response
     */
    public function store(StoreTrainingPeriodRequest $request)
    {
        try {

            $trainingPeriodCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $trainingPeriod = $this->trainingPeriodRepository->create($trainingPeriodCreate);

            return $this->sendResponse($trainingPeriod, 'Training Period stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Training Period', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/training-periods/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show training period - Ver los datos de un Periodo de entrenamiento",
    *       operationId="show-training-periods",
    *       description="Return data to training period  - Retorna los datos de un Periodo de entrenamiento",
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

            $trainingPeriod = $this->trainingPeriodRepository->findOneBy(["code" => $code]);

            if (!$trainingPeriod) {
                return $this->sendError("Error", "Training Period not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($trainingPeriod, 'Training Period information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Training Period', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/training-periods/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Edit training period - Editar un Periodo de entrenamiento",
    *       operationId="training-periods-edit",
    *       description="Edit a training period - Edita un Periodo de entrenamiento",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTrainingPeriodRequest")
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
     * @param UpdateTrainingPeriodRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTrainingPeriodRequest $request, $code)
    {
        try {

            $trainingPeriod = $this->trainingPeriodRepository->findOneBy(["code" => $code]);

            if (!$trainingPeriod) {
                return $this->sendError("Error", "Training Period not found", Response::HTTP_NOT_FOUND);
            }

            $trainingPeriodUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->trainingPeriodRepository->update($trainingPeriodUpdate, $trainingPeriod);

             return $this->sendResponse($updated, 'Training Period data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Training Period', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/training/training-periods/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete training period - Elimina un Periodo de entrenamiento",
    *       operationId="training-periods-delete",
    *       description="Delete a training period - Elimina un Periodo de entrenamiento",
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
            $trainingPeriod = $this->trainingPeriodRepository->findOneBy(["code" => $code]);

            if (!$trainingPeriod) {
                return $this->sendError("Error", "Training Period not found", Response::HTTP_NOT_FOUND);
            }

            return $this->trainingPeriodRepository->delete($trainingPeriod->id)
            ? $this->sendResponse(null, 'Training Period deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Training Period Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Training Period', $exception->getMessage());
        }
    }

}
