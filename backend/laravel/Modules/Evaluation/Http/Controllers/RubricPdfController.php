<?php

namespace Modules\Evaluation\Http\Controllers;

use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Rest\BaseController;
use Illuminate\Support\Facades\App;
use App\Traits\TranslationTrait;
use Exception;

class RubricPdfController extends BaseController
{
    use TranslationTrait;

     /**
     * Repository
     *
     * @var $rubricRepository
     */
    protected $rubricRepository;

     /**
     * Repository
     *
     * @var $alumnRepository
     */
    protected $alumnRepository;

     /**
     * Repository
     *
     * @var $evaluationResultService
     */
    protected $evaluationResultService;

    public function __construct(
        RubricRepositoryInterface $rubricRepository,
        AlumnRepositoryInterface $alumnRepository,
        EvaluationResultServiceInterface $evaluationResultService
    ) {
        $this->rubricRepository = $rubricRepository;
        $this->alumnRepository = $alumnRepository;
        $this->evaluationResultService = $evaluationResultService;
    }

    /**
     * Export a rubric with their indicators, associate to
     * the classrooms and their competences
     *
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/evaluation/rubrics-pdf/{rubric_id}/alumn/{alumn_id}/classroom/{classroom_academic_year_id}",
     *      tags={"Rubrics"},
     *      summary="Export a rubric with their indicators",
     *      operationId="rubrics-pdf",
     *      description="Export a rubric with their indicators, associate to the classrooms and their competences",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/rubric_id" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_academic_year_id" ),
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
    public function generate($rubric_id, $alumn_id, $classroom_academic_year_id)
    {
        try {
            $evaluation = $this->evaluationResultService->getResult($rubric_id, $alumn_id, $classroom_academic_year_id);
            $rubric = $this->rubricRepository->getExportDataById($rubric_id);
            $alumn = $this->alumnRepository->find($alumn_id);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('evaluation::rubric-detail', compact('evaluation', 'rubric', 'alumn'));

            return new HttpResponse($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('rubric.pdf') . '"',
                'Content-Length' => null,
            ]);
        } catch (RubricDoesNotExistException $exception) {
            return $this->sendError($this->translator('rubric_not_exist'), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError($this->translator('rubric_export_error'), $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
