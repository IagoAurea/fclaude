<?php


namespace Modules\Psychology\Http\Controllers;

use \Exception;
use App\Traits\TranslationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Staff\Services\StaffService;
use Modules\Activity\Events\ActivityEvent;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Psychology\Services\PsychologyService;
use Modules\Psychology\Http\Requests\PsychologyReportRequest;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Psychology\Repositories\Interfaces\PsychologyReportRepositoryInterface;

class PsychologyReportController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * @var $psychologyReportRepository
     */
    protected $psychologyReportRepository;

    /**
     * Repository
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * Service
     * @var $psychologyService
     */
    protected $psychologyService;
    
    /**
     * @var $staffService
     */
    protected $staffService;

    /**
     * PsychologyReportController constructor.
     * @param PsychologyReportRepositoryInterface $psychologyReportRepository
     */
    public function __construct(
        PsychologyReportRepositoryInterface $psychologyReportRepository,
        PlayerRepositoryInterface $playerRepository,
        StaffService $staffService,
        PsychologyService $psychologyService
    ) {
        $this->psychologyReportRepository = $psychologyReportRepository;
        $this->playerRepository = $playerRepository;
        $this->staffService = $staffService;
        $this->psychologyService = $psychologyService;
    }

     /**
     * Retrieve all phychology reports created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/psychologies/reports/list/user",
     *  tags={"Psychology"},
     *  summary="List all phychology reports created by user authenticate
     *  - Lista todos los reportes de psicologia creado por el usuario",
     *  operationId="list-tests-user",
     *  description="List all phychology reports created by user authenticate -
     *  Lista todos los reportes de psicologia creado por el usuario",
     *  security={{"bearerAuth": {} }},
     *   @OA\Parameter(
     *      ref="#/components/parameters/_locale"
     *   ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function getAllPsychologyReportsUser()
    {
        $reports = $this->psychologyService->allPsychologyReportsByUser(Auth::id());

        return $this->sendResponse($reports, 'List all psychology reports of user');
    }

    /**
     * Get report by ID
     * @param $id
     * @return JsonResponse
     */
    public function reportById($id)
    {
        $psychologyReport = $this->psychologyReportRepository->find($id);
        if ($psychologyReport) {
            return $this->sendResponse($psychologyReport, $this->translator('psychology_report_detail'));
        }

        return $this->sendError(
            $this->translator('psychology_report_not_exists'),
            null,
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @OA\Get(
     *       path="/api/v1/psychologies/reports/{psychology_report_id}/pdf",
     *       tags={"Psychology"},
     *       summary="Get Psychology report PDF - Obtener PDF de reporte de psicología",
     *       operationId="pdf-psychology-report",
     *       description="Return data to Psychology report  - Retorna los datos de un reporte de psicología",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/psychology_report_id" ),
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
     * Generate PDF
     *
     * @param $id
     * @return JsonResponse
     */
    public function reportPdf($id)
    {
        $data = $this->psychologyReportRepository->find($id);

        if (!$data) {
            return $this->sendError(
                $this->translator('psychology_report_not_exists'),
                null,
                Response::HTTP_NOT_FOUND
            );
        }

        $dompdf = App::make('dompdf.wrapper');
        $pdf = $dompdf->loadView('psychology::report', compact('data'));

        return new HttpResponse($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . sprintf('psychology-report-%s.pdf', $id) . '"',
            'Content-Length' => null,
        ]);
    }

    /**
     * @OA\Get(
     *       path="/api/v1/psychologies/reports/{player_id}/pdfs",
     *       tags={"Psychology"},
     *       summary="Get Psychology report PDFs of a player - Obtener PDFs de reporte de psicología de un jugador",
     *       operationId="pdfs-psychology-report",
     *       description="Return data to Psychology report  - Retorna los datos de un reporte de psicología",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     * Generate PDF
     *
     * @param $id
     * @return JsonResponse
     */
    public function reportsPdf($player_id)
    {
        $search = [
            "player_id" => $player_id
        ];

        $data = $this->psychologyReportRepository->findBy($search);

        if (count($data) === 0) {
            return $this->sendError(
                $this->translator('psychology_report_not_exists'),
                null,
                Response::HTTP_NOT_FOUND
            );
        }

        $dompdf = App::make('dompdf.wrapper');
        $pdf = $dompdf->loadView('psychology::reports', compact('data'));

        return new HttpResponse($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . sprintf('psychology-reports-%s.pdf', $player_id) . '"',
            'Content-Length' => null,
        ]);
    }

    /**
     * Create a new report
     * @param PsychologyReportRequest $request
     * @return JsonResponse
     */
    public function create(PsychologyReportRequest $request)
    {
        $permission = Gate::inspect('store-psychology', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            if ($request->has('staff_id') && $request->has('staff_name')) {

                return $this->sendError(
                    $this->translator('psychology_use_only_one_staff_id_or_name'),
                    [],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $request['user_id'] = Auth::id();

            $psychologyReport = $this->psychologyReportRepository->create($request->all());

            event(
                new ActivityEvent(
                    Auth::user(),
                    $psychologyReport->player->team->club,
                    'psychology_report_created',
                    $psychologyReport->player->team
                )
            );

            return $this->sendResponse($psychologyReport, $this->translator('psychology_report_created'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('an_error_has_occurred'),
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Update a report by ID
     * @param $id "Identifier of PsychologyReport"
     * @param PsychologyReportRequest $request
     * @return JsonResponse
     */
    public function update($id, PsychologyReportRequest $request)
    {
        $permission = Gate::inspect('update-psychology', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $psychologyReport = $this->psychologyReportRepository->find($id);

            if (!$psychologyReport)
                return $this->sendError(
                    'Psychology report not exists',
                    'NOT_FOUND',
                    Response::HTTP_NOT_FOUND
                );

            $this->psychologyReportRepository->update($request->all(), [
                'id' => $id
            ]);

            $psychologyReport = $this->psychologyReportRepository->find($id);

            event(
                new ActivityEvent(
                    Auth::user(),
                    $psychologyReport->player->team->club,
                    'psychology_report_updated',
                    $psychologyReport->player->team
                )
            );

            return $this->sendResponse($psychologyReport, $this->translator('psychology_report_updated'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('an_error_has_occurred'),
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Delete a report by ID
     * @param $id "Identifier of PsychologyReport"
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $psychologyReport = $this->psychologyReportRepository->find($id);

            $permission = Gate::inspect('delete-psychology', $psychologyReport->player->team_id);

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }

            if (!$psychologyReport) {
                return $this->sendError("Psychology report not exists", "NOT_FOUND", Response::HTTP_NOT_FOUND);
            }

            event(
                new ActivityEvent(Auth::user(), $psychologyReport->player->team->club,
                    'psychology_report_deleted', $psychologyReport->player->team)
            );

            $this->psychologyReportRepository->delete($id);

            return $this->sendResponse($psychologyReport, $this->translator('psychology_report_deleted'));
        } catch (Exception $exception) {
            return $this->sendError(
                $this->translator('an_error_has_occurred'),
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
