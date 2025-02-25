<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreTypeExerciseSessionRequest;
use Modules\Training\Http\Requests\UpdateTypeExerciseSessionRequest;
use Modules\Training\Repositories\Interfaces\TypeExerciseSessionRepositoryInterface;

class TypeExerciseSessionController extends BaseController
{
    /**
     * @var $typeExerciseSessionRepository
     */
    protected $typeSessionRepository;


    public function __construct(
        TypeExerciseSessionRepositoryInterface $typeSessionRepository
    )
    {
        $this->typeSessionRepository = $typeSessionRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/training/type-exercise-session",
    *       tags={"ExerciseSession"},
    *       summary="Get list type exercise session - Lista de tipos de sesiones de ejercicio",
    *       operationId="list-type-exercise-session",
    *       description="Return data list type exercise session  - Retorna listado de tipos de sesiones de ejercicio",
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
     * Display a listing of Type Exercise Session.
     * @return Response
     */
    public function index()
    {
        $typeSession = $this->typeSessionRepository->findAllTranslated();

        return $this->sendResponse($typeSession, 'List of Type exercise session');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/type-exercise-session",
    *       tags={"ExerciseSession"},
    *       summary="Stored Type Exercise Session - guardar un nuevo tipo de sesión de ejercicio ",
    *       operationId="type-exercise-session-store",
    *       description="Store a new Type Exercise Session - Guarda un nuevo tipo de sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreTypeExerciseSessionRequest")
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
     * @param StoreTypeExerciseSessionRequest $request
     * @return Response
     */
    public function store(StoreTypeExerciseSessionRequest $request)
    {
        try {

            $typeSessionCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code
            ];

            $typeSession = $this->typeSessionRepository->create($typeSessionCreate);

            return $this->sendResponse($typeSession, 'Type exercise session stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Type exercise session', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/type-exercise-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show Type Exercise Session - Ver los datos de un tipo de sesión de ejercicio",
    *       operationId="show-type-exercise-session",
    *       description="Return data to Type Exercise Session  - Retorna los datos de un tipo de sesión de ejercicio",
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
            $typeSession = $this->typeSessionRepository->findOneBy(["code" => $code]);

            if (!$typeSession) {
                return $this->sendError("Error", "Type exercise session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($typeSession, 'Type exercise session information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Type exercise session', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/type-exercise-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Edit Type Exercise Session - Editar un tipo de sesión de ejercicio",
    *       operationId="type-exercise-session-edit",
    *       description="Edit a Type Exercise Session - Edita un tipo de sesión de ejercicio",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTypeExerciseSessionRequest")
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
     * @param UpdateTypeExerciseSessionRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTypeExerciseSessionRequest $request, $code)
    {
        try {
            $typeSession = $this->typeSessionRepository->findOneBy(["code" => $code]);

            if (!$typeSession) {
                return $this->sendError("Error", "Type exercise session not found", Response::HTTP_NOT_FOUND);
            }

            $typeSessionUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

             $updated = $this->typeSessionRepository->update($typeSessionUpdate, $typeSession);

             return $this->sendResponse($updated, 'Type exercise session data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Type exercise session', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/training/type-exercise-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete Type Exercise Session- Elimina un tipo de sesión de ejercicio",
    *       operationId="type-exercise-session-delete",
    *       description="Delete a Type Exercise Session - Elimina un tipo de sesión de ejercicio",
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

            $typeSession = $this->typeSessionRepository->findOneBy(["code" => $code]);

            if (!$typeSession) {
                return $this->sendError("Error", "Type exercise session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->typeSessionRepository->delete($typeSession->id)
            ? $this->sendResponse(null, 'Type exercise session deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Type exercise session Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Type exercise session', $exception->getMessage());
        }
    }

   
}
