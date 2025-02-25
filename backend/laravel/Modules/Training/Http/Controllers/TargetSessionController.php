<?php

namespace Modules\Training\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Training\Http\Requests\StoreTargetSessionRequest;
use Modules\Training\Http\Requests\UpdateTargetSessionRequest;
use Modules\Training\Repositories\Interfaces\TargetSessionRepositoryInterface;

class TargetSessionController extends BaseController
{
    /**
     * @var $targetSessionRepository
     */
    protected $targetSessionRepository;


    public function __construct(
        TargetSessionRepositoryInterface $targetSessionRepository
    )
    {
        $this->targetSessionRepository = $targetSessionRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/targets",
    *       tags={"ExerciseSession"},
    *       summary="Get list targets - Lista de objetivos ",
    *       operationId="list-targets",
    *       description="Return data list targets  - Retorna listado de objetivos ",
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
     * Display a listing of Target.
     * @return Response
     */
    public function index()
    {
        $targets = $this->targetSessionRepository->findAllTranslated();

        return $this->sendResponse($targets, 'List Targets session');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/targets/content/{content_exercise_code}/{sport_code}",
    *       tags={"ExerciseSession"},
    *       summary="Get list targets by content and sport - Lista de objetivos por contenido y deporte",
    *       operationId="list-targets-content",
    *       description="Return data list targets by content and sport -
    *       Retorna listado de objetivos por contenido y deporte ",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/content_exercise_code" ),
    *       @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
     * Display a listing of Target.
     * @param int $content_exercise_code
     * @param int $sport_code
     * @return Response
     */
    public function listTargetsByContent($content_exercise_code,$sport_code)
    {
        $targets = $this->targetSessionRepository->findAllByContent($content_exercise_code,$sport_code);

        return $this->sendResponse($targets, 'List Targets By Content');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/targets/sub-content/{sub_content_session_code}/{sport_code}",
    *       tags={"ExerciseSession"},
    *       summary="Get list targets by sub content and sport- Lista de objetivos por subcontenido y deporte ",
    *       operationId="list-targets-subcontent",
    *       description="Return data list targets by sub content and sport -
    *       Retorna listado de objetivos por subcontenido y deporte ",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/sub_content_session_code" ),
    *       @OA\Parameter( ref="#/components/parameters/sport_code" ),
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
     * Display a listing of Target.
     * @param int $sub_content_session_code
     * @param int $sport_code
     * @return Response
     */
    public function listTargetsBySubContent($sub_content_session_code,$sport_code)
    {
        $targets = $this->targetSessionRepository->findAllBySubContent($sub_content_session_code,$sport_code);

        return $this->sendResponse($targets, 'List Targets By Target');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/training/targets",
    *       tags={"ExerciseSession"},
    *       summary="Stored Target - guardar un nuevo objetivo ",
    *       operationId="targets-store",
    *       description="Store a new Target - Guarda un nuevo objetivo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StoreTargetSessionRequest")
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
     * @param StoreTargetSessionRequest $request
     * @return Response
     */
    public function store(StoreTargetSessionRequest $request)
    {
        try {

            $targetSessionCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'content_exercise_id' =>  $request->content_exercise_id,
                'sub_content_session_id' => $request->sub_content_session_id,
                'sport_id'  => $request->sport_id,
            ];

            $targetSession = $this->targetSessionRepository->create($targetSessionCreate);

            return $this->sendResponse($targetSession, 'Target Session stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Target Session', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/training/targets/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Show Target - Ver los datos de un objetivo",
    *       operationId="show-targets",
    *       description="Return data to Target  - Retorna los datos de un objetivo",
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

            $targetSession = $this->targetSessionRepository->findOneBy(["code" => $code]);

            if (!$targetSession) {
                return $this->sendError("Error", "Target Session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($targetSession, 'Target Session information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Target Session ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/training/targets/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Edit Target - Editar un objetivo",
    *       operationId="targets-edit",
    *       description="Edit a Target - Edita un objetivo",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateTargetSessionRequest")
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
     * @param UpdateTargetSessionRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateTargetSessionRequest $request, $code)
    {
        try {
            $targetSession = $this->targetSessionRepository->findOneBy(["code" => $code]);

            if(!$targetSession) {
                return $this->sendError("Error", "Target Session not found", Response::HTTP_NOT_FOUND);
            }

            $targetSessionUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'content_exercise_id'  => $request->content_exercise_id,
                'sub_content_session_id' => $request->sub_content_session_id,
                'sport_id'  => $request->sport_id,
            ];

             $updated = $this->targetSessionRepository->update($targetSessionUpdate, $targetSession);

             return $this->sendResponse($updated, 'Target Session data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Target Session', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/training/targets/{code}",
    *       tags={"ExerciseSession"},
    *       summary="Delete Target- Elimina un objetivo",
    *       operationId="targets-delete",
    *       description="Delete a Target - Elimina un objetivo",
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

            $targetSession = $this->targetSessionRepository->findOneBy(["code" => $code]);

            if (!$targetSession) {
                return $this->sendError("Error", "Target Session not found", Response::HTTP_NOT_FOUND);
            }

            return $this->targetSessionRepository->delete($targetSession->id)
            ? $this->sendResponse(null, 'Target Session deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Target Session Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Target Session', $exception->getMessage());
        }
    }
    
}
