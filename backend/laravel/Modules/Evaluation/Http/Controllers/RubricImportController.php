<?php

namespace Modules\Evaluation\Http\Controllers;

use Exception;
use App\Traits\TranslationTrait;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Rest\BaseController;
use Modules\Evaluation\Imports\RubricsImport;
use Symfony\Component\HttpFoundation\Response;
use Modules\Evaluation\Exceptions\RubricPayloadDataIsWrongFormattedException;

class RubricImportController extends BaseController
{
    use TranslationTrait;

    /**
     * Import a rubric with their indicators, associate to
     * the classrooms and their competences
     * 
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics-import",
     *      tags={"Rubrics"},
     *      summary="Import a rubric with their indicators",
     *      operationId="rubrics-import",
     *      description="Import a rubric with their indicators, associate to the classrooms and their competences",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          ref="#/components/responses/responseCreated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/unprocessableEntity"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      )
     *  )
     **/
    public function import()
    {
        if (!request()->file('rubric')) {
            return $this->sendError('The no file uploaded', [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            Excel::import(new RubricsImport, request()->file('rubric'));

            return $this->sendResponse(true, $this->translator('rubric_import'), Response::HTTP_CREATED);
        } catch (RubricPayloadDataIsWrongFormattedException $exception) {
            return $this->sendError($this->translator('rubic_import_wrong'),
                $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_import_error'),
                $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
