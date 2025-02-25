<?php

namespace Modules\Qualification\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Rest\BaseController;
use Modules\Qualification\Services\QualificationService;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;

class QualificationPdfController extends BaseController
{
    /**
     * @var $qualificationService
     */
    protected $qualificationService;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        AlumnRepositoryInterface $alumnRepository,
        QualificationService $qualificationService
    ) {
        $this->qualificationService = $qualificationService;
        $this->alumnRepository = $alumnRepository;
    }

    /**
     * Display a list of qualifications
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/{qualification_pdf_id}/alumn/{alumn_id}/classroom/{classroom_id}/pdf",
     *      tags={"Qualification"},
     *      summary="PDF Qualification - PDF Calificaciones",
     *      operationId="quantification-pdf",
     *      description="Return pdf quantification",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/qualification_pdf_id" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_id" ),
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
    public function generate($qualification_id, $alumn_id, $classroom_academic_year_id)
    {
        try {
            $qualification = $this->qualificationService->loadPdf($qualification_id, $alumn_id, $classroom_academic_year_id);
            $alumn = $this->alumnRepository->find($alumn_id);
            $competence = $qualification['competences'];

            $dompdf = App::make('dompdf.wrapper');
            
            $pdf = $dompdf->loadView('qualification::qualification', compact('qualification', 'alumn', 'competence'));

            return new HttpResponse($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('qualification.pdf') . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving pdf exercise', $exception->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a list of qualifications
     *
     * @param Request $request
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/qualification/alumn/{alumn_id}/classroom/{classroom_id}/pdf",
     *      tags={"Qualification"},
     *      summary="PDF Qualification All - PDF Calificaciones Aleatorias",
     *      operationId="quantification-all-pdf",
     *      description="Return pdf quantification",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *      @OA\Parameter( ref="#/components/parameters/classroom_id" ),
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
    public function generateAllPdf($alumn_id, $classroom_academic_year_id)
    {
        try {
            $qualification = $this->qualificationService->loadPdfAll($alumn_id, $classroom_academic_year_id);
            $alumn = $this->alumnRepository->find($alumn_id);
            $competence = $qualification['competences'];

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('qualification::qualification-all', compact('qualification','competence', 'alumn'));
            return new HttpResponse($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('qualification-all.pdf') . '"', 
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving pdf exercise', $exception->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}