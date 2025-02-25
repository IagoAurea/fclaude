<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreSubContentSessionRequest;
use Modules\Training\Http\Requests\UpdateSubContentSessionRequest;
use Modules\Training\Repositories\Interfaces\SubContentSessionRepositoryInterface;

class SubContentSessionController extends BaseController
{
    /**
     * @var $subContentRepository
     */
    protected $subContentRepository;


    public function __construct(
        SubContentSessionRepositoryInterface $subContentRepository
    )
    {
        $this->subContentRepository = $subContentRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/training/sub-content-session",
    *       tags={"ExerciseSession"},
    *       summary="Get list sub-content-session - Lista de sub contenidos de sesión",
    *       operationId="list-sub-content-session",
    *       description="Return data list sub-content-session  - Retorna listado de sub contenidos de sesión",
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
     * Display a listing of Sub Content Session.
     * @return Response
     */
    public function index()
    {
        $subContent = $this->subContentRepository->findAllTranslated();

        return $this->sendResponse($subContent, 'List of Sub Content Session');
    }

    /**
     * Display a listing of Sub Content Session.
     * @return Response
     */
    public function listByContent($code)
    {
        $subContent = $this->subContentRepository->listByContent($code);

        return $this->sendResponse($subContent, 'List of Sub Content Session by Content');
    }


    /**
    * @OA\Post(
    *       path="/api/v1/training/sub-content-session",
    *       tags={"ExerciseSession"},
    *       summary="Stored Sub Content - guardar un nuevo sub contenido ",
    *       operationId="sub-content-session-store",
    *       description="Store a new sub content session - Guarda un nuevo sub contenido",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreSubContentSessionRequest")
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
     * @param StoreSubContentSessionRequest $request
     * @return Response
     */
    public function store(StoreSubContentSessionRequest $request)
    {
        try {

            $subContentCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'content_exercise_id'  => $request->content_exercise_id,
            ];

            $subContent = $this->subContentRepository->create($subContentCreate);

            return $this->sendResponse($subContent, 'Sub Content Session stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Sub Content Session', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/sub-content-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show sub content session - Ver los datos de un sub contenido",
    *       operationId="show-sub-content-session",
    *       description="Return data to sub content session  - Retorna los datos de un sub contenido",
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

            $subContent = $this->subContentRepository->findOneBy(["code" => $code]);

            if (!$subContent) {
                return $this->sendError("Error", "Sub Content Session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($subContent, 'Sub Content Session information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Sub Content Session', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/sub-content-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Edit sub content session - Editar un sub contenido",
    *       operationId="sub-content-session-edit",
    *       description="Edit a sub content session - Edita un sub contenido",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateSubContentSessionRequest")
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
     * @param UpdateSubContentSessionRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateSubContentSessionRequest $request, $code)
    {
        try {
            $subContent = $this->subContentRepository->findOneBy(["code" => $code]);

            if (!$subContent) {
                return $this->sendError("Error", "Sub Content Session not found", Response::HTTP_NOT_FOUND);
            }

            $subContentUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'content_exercise_id'  => $request->content_exercise_id,
            ];

             $updated = $this->subContentRepository->update($subContentUpdate, $subContent);

             return $this->sendResponse($updated, 'Sub Content Session data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Sub Content Session', $exception->getMessage());
        }
    }


    /**
    * @OA\Delete(
    *       path="/api/v1/training/sub-content-session/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete sub content session- Elimina un sub contenido",
    *       operationId="sub-content-session-delete",
    *       description="Delete a sub content session - Elimina un sub contenido",
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

            $subContent = $this->subContentRepository->findOneBy(["code" => $code]);

            if (!$subContent) {
                return $this->sendError("Error", "Sub Content Session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->subContentRepository->delete($subContent->id)
            ? $this->sendResponse(null, 'Sub Content Session deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Sub Content Session Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Type exercise session', $exception->getMessage());
        }
    }
   
}
