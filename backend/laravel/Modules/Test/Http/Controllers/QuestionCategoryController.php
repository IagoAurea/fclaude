<?php

namespace Modules\Test\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Test\Http\Requests\StoreQuestionCategoryRequest;
use Modules\Test\Http\Requests\UpdateQuestionCategoryRequest;
use Modules\Test\Repositories\Interfaces\QuestionCategoryRepositoryInterface;

class QuestionCategoryController extends BaseController
{
   /**
     * @var $questionCategoryRepository
     */
    protected $questionCategoryRepository;


    public function __construct(
        QuestionCategoryRepositoryInterface $questionCategoryRepository
    )
    {
        $this->questionCategoryRepository = $questionCategoryRepository;
    }


    /**
    * @OA\Get(
    *       path="/api/v1/tests/question-categories",
    *       tags={"Test"},
    *       summary="Get list question categories - Lista de categorias de pregunta",
    *       operationId="list-question-categories",
    *       description="Return data list categories - Retorna listado de categorias de pregunta",
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
     * Display a listing of categories by questions.
     * @return Response
     */
    public function index()
    {
        $questionCategory = $this->questionCategoryRepository->findAllTranslated();

        return $this->sendResponse($questionCategory, 'List of Question Category');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/tests/question-categories",
    *       tags={"Test"},
    *       summary="Stored Question Category - guardar categoria de pregunta",
    *       operationId="question-category-store",
    *       description="Store a new question category - Guarda una nueva categoria para las preguntas",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreQuestionCategoryRequest")
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
     * @param StoreQuestionCategoryRequest $request
     * @return Response
     */
    public function store(StoreQuestionCategoryRequest $request)
    {
        try {

            $questionCategoryCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                
            ];

            if ($request->question_category_code) {
                $questionCategoryCreate['question_category_code'] = $request->question_category_code;
            }

            $questionCategory = $this->questionCategoryRepository->create($questionCategoryCreate);

            return $this->sendResponse($questionCategory, 'Question Category stored', Response::HTTP_CREATED);
        }
        catch (Exception $exception) {
            return $this->sendError('Error by creating Question Category', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/tests/question-categories/{code}",
    *       tags={"Test"},
    *       summary="Show Question Category - Ver los datos de una categoria",
    *       operationId="show-question-category",
    *       description="Return data to question category  - Retorna los datos de una categoria de preguntas",
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
            $questionCategory = $this->questionCategoryRepository->findOneBy(["code" => $code]);

            if(!$questionCategory) {
                return $this->sendError("Error", "Question Category not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($questionCategory, 'Question Category information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Question Category ', $exception->getMessage());
        }
    }

    /**
    * @OA\Put(
    *       path="/api/v1/tests/question-categories/{code}",
    *       tags={"Test"},
    *       summary="Edit Question Category - Editar categoria de pregunta",
    *       operationId="question-category-edit",
    *       description="Edit a question category - Edita una categoria para las preguntas",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UpdateQuestionCategoryRequest")
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
     * @param UpdateQuestionCategoryRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateQuestionCategoryRequest $request, $code)
    {
        try {

            $questionCategory = $this->questionCategoryRepository->findOneBy(["code" => $code]);

            if(!$questionCategory) {
                return $this->sendError("Error", "Question Category not found", Response::HTTP_NOT_FOUND);
            }

            $questionCategoryUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

            if ($request->question_category_code) {
                $questionCategoryCreate['question_category_code'] = $request->question_category_code;
            }

             $updated = $this->questionCategoryRepository->update($questionCategoryUpdate, $questionCategory);

             return $this->sendResponse($updated, 'Question Category data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Question Category', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/tests/question-categories/{code}",
    *       tags={"Test"},
    *       summary="Delete Question Category - Elimina categoria de pregunta",
    *       operationId="question-category-delete",
    *       description="Delete a question category - Elimina una categoria para las preguntas",
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
            $questionCategory = $this->questionCategoryRepository->findOneBy(["code" => $code]);

            if(!$questionCategory) {
                return $this->sendError("Error", "Question Category not found", Response::HTTP_NOT_FOUND);
            }

            return $this->questionCategoryRepository->delete($questionCategory->id)
            ? $this->sendResponse(null, 'Question Category deleted', Response::HTTP_ACCEPTED)
            : $this->sendError('Question Category Not Existing');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Question Category', $exception->getMessage());
        }
    }
}
