<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreQuestionRequest;
use Modules\Test\Http\Requests\UpdateQuestionRequest;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionController extends BaseController
{
   /**
     * @var $questionRepository
     */
    protected $questionRepository;


    public function __construct(
        QuestionRepositoryInterface $questionRepository
    )
    {
        $this->questionRepository = $questionRepository;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/tests/questions",
    *       tags={"Test"},
    *       summary="Get list questions  - Lista de preguntas",
    *       operationId="list-questions",
    *       description="Return data list question - Retorna el listado de pregunta",
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
     * Display a listing of question.
     * @return Response
     */
    public function index()
    {
        $question = $this->questionRepository->findAllTranslated();

        return $this->sendResponse($question, 'List of Question');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/questions/by-category/{code}",
    *       tags={"Test"},
    *       summary="Get list question by categories - Lista de preguntas por categoría",
    *       operationId="list-question-by-categories",
    *       description="Return data list question by categories - Retorna listado de preguntas por categoría",
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
     * Display a listing of question by category.
     * @return Response
     */
    public function questionsByCategory($code)
    {
        $question = $this->questionRepository->questionsByCategory($code);

        return $this->sendResponse($question, 'List of Question by Category');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/questions",
    *       tags={"Test"},
    *       summary="Stored Question - guardar pregunta",
    *       operationId="question-store",
    *       description="Store a new question - Guarda una nueva pregunta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreQuestionRequest")
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
     * @param StoreQuestionRequest $request
     * @return Response
     */
    public function store(StoreQuestionRequest $request)
    {
        try {

            $questionCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'question_category_code' => $request->question_category_code
                
            ];

            $question = $this->questionRepository->create($questionCreate);

            return $this->sendResponse($question, 'Question stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Question', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/questions/{code}",
    *       tags={"Test"},
    *       summary="Show Question  - Ver los datos de una pregunta",
    *       operationId="show-question",
    *       description="Return data to question  - Retorna los datos de una pregunta",
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
            $question = $this->questionRepository->findOneBy(["code" => $code]);

            if(!$question) {
                return $this->sendError("Error", "Question not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($question, 'Question information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Question', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/questions/{code}",
    *       tags={"Test"},
    *       summary="Edit Question  - Editar pregunta",
    *       operationId="question-edit",
    *       description="Edit a question  - Edita una pregunta",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateQuestionRequest")
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
     * @param UpdateQuestionRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateQuestionRequest  $request, $code)
    {
        try {
            $question = $this->questionRepository->findOneBy(["code" => $code]);

            if(!$question) {
                return $this->sendError("Error", "Question not found", Response::HTTP_NOT_FOUND);
            }

            $questionUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'question_category_code' => $request->question_category_code
            ];

             $updated = $this->questionRepository->update($questionUpdate, $question);

             return $this->sendResponse($updated, 'Question data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Question', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/questions/{code}",
    *       tags={"Test"},
    *       summary="Delete Question  - Elimina una pregunta",
    *       operationId="question-delete",
    *       description="Delete a question - Elimina una pregunta",
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
            $question = $this->questionRepository->findOneBy(["code" => $code]);

            if(!$question) {
                return $this->sendError("Error", "Question not found", Response::HTTP_NOT_FOUND);
            }

            return $this->questionRepository->delete($question->id)
            ? $this->sendResponse(null, 'Question deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Question Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Question', $exception->getMessage());
        }
    }
}
