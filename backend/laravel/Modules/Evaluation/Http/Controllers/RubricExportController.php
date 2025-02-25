<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Evaluation\Exports\RubricExport;
use Maatwebsite\Excel\Excel as ExcelModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\TranslationTrait;
use Exception;

class RubricExportController extends BaseController
{
    use TranslationTrait;

     /**
     * Repository
     *
     * @var $rubricRepository
     */
    protected $rubricRepository;

    public function __construct(RubricRepositoryInterface $rubricRepository)
    {
        $this->rubricRepository = $rubricRepository;
    }

    /**
     * Export a rubric with their indicators, associate to
     * the classrooms and their competences
     * 
     * @return Response
     */
    /**
     *  @OA\Post(
     *      path="/api/v1/evaluation/rubrics-export/{rubric_id}",
     *      tags={"Rubrics"},
     *      summary="Export a rubric with their indicators",
     *      operationId="rubrics-export",
     *      description="Export a rubric with their indicators, associate to the classrooms and their competences",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
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
    public function export($id)
    {
        try {
            $payload = $this->rubricRepository->getExportDataById($id);

            return Excel::download(new RubricExport($payload), 'rubrics.csv', ExcelModel::CSV);
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_export_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
