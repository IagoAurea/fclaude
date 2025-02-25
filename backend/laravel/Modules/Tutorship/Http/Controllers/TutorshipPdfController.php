<?php

namespace Modules\Tutorship\Http\Controllers;

use Modules\Tutorship\Services\Interfaces\TutorshipServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class TutorshipPdfController extends BaseController
{
    public function __construct(TutorshipServiceInterface $tutorshipService)
    {
        $this->tutorshipService = $tutorshipService;
    }

    /**
     * Generate the tutorship report by the tutorship id
     * 
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/pdf/{tutorship_id}",
     *      tags={"Tutorships"},
     *      summary="Generate the tutorship report by id",
     *      operationId="tutorships-pdf",
     *      description="Generate the tutorship report by the tutorship id",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),

     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function generatePDF($id)
    {
        try {
            return $this->tutorshipService->generatePdf($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The tutorship %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while trying to generate the tutorship pdf', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Generate the tutorship report by the tutorship alumn_id
     * 
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/pdfs/{tutorship_id}",
     *      tags={"Tutorships"},
     *      summary="Generate the tutorship reports by alum_id",
     *      operationId="tutorships-pdfs",
     *      description="Generate the tutorship reports by the tutorship alum_id",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),

     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function generatePDFs($alumn_id)
    {
        try {
            return $this->tutorshipService->generatePdfs($alumn_id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The tutorship reports with alumn %s does not exist', $alumn_id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while trying to generate the tutorship pdf', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Generate the tutorship report by the tutorship id
     * 
     * @return Response
     */
    /**
     *  @OA\Get(
     *      path="/api/v1/tutorships/pdf-test/{tutorship_id}",
     *      tags={"Tutorships"},
     *      summary="Generate the tutorship report by id",
     *      operationId="tutorships-pdf-test",
     *      description="Generate the tutorship report by the tutorship id",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/tutorship_id" ),

     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
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
    public function generatePDFTest($id)
    {
        try {
            return $this->tutorshipService->generatePdfTest($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError(sprintf('The tutorship %s does not exist', $id), $exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError('There was an error while trying to generate the tutorship pdf', $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
