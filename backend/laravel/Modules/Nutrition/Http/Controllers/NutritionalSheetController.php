<?php

namespace Modules\Nutrition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Player\Entities\Player;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Modules\Nutrition\Services\NutritionService;
use Modules\Nutrition\Http\Requests\StoreNutritionalSheetRequest;
use Modules\Nutrition\Http\Requests\UpdateNutritionalSheetRequest;
use Modules\Nutrition\Repositories\Interfaces\NutritionalSheetRepositoryInterface;


class NutritionalSheetController extends BaseController
{

    /**
     * @var $nutritionalSheetRepository
     */
    protected $nutritionalSheetRepository;

    /**
     * @var $athleteActivityRepository
     */
    protected $athleteActivityRepository;
    
    /**
     * @var $nutritionService
     */
    protected $nutritionService;


    public function __construct(
        NutritionalSheetRepositoryInterface $nutritionalSheetRepository,
        NutritionService $nutritionService
    ) {
        $this->nutritionalSheetRepository = $nutritionalSheetRepository;
        $this->nutritionService = $nutritionService;
    }

     /**
     * Retrieve all tests created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/nutrition/nutritional-sheet/list/user",
     *  tags={"Nutrition"},
     *  summary="List all nutritional sheets created by user authenticate
     *  - Lista todos las fichas nutricional creado por el usuario",
     *  operationId="list-nutritional-sheet-user",
     *  description="List all nutritional sheets created by user authenticate -
     *  Lista todos las fichas nutricional creado por el usuario",
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
    public function getAllNutritionalSheetsUser()
    {
        $sheets = $this->nutritionService->allNutritionalSheetsByUser(Auth::id());

        return $this->sendResponse($sheets, 'List all nutritional sheets of user');
    }

    /**
     * @OA\Post(
     *       path="/api/v1/nutrition/nutritional-sheet",
     *       tags={"Nutrition"},
     *       summary="Stored nutritional sheet - guardar una nueva ficha nutricional",
     *       operationId="nutritional-sheet-store",
     *       description="Store a new nutritional sheet - Guarda una nueva ficha nutricional",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StoreNutritionalSheetRequest")
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
     * @param Request $request
     * @return json
     */
    public function store(StoreNutritionalSheetRequest $request)
    {
        $user = Auth::user();

        $request['user_id'] = $user->id;

        $permission = Gate::inspect('store-nutrition', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $nutritionalSheet = $this->nutritionalSheetRepository->createNutritionalSheet($request);

            event(
                new ActivityEvent(
                    $user,
                    $nutritionalSheet->player->team->club,
                    'nutritional_sheet_created',
                    $nutritionalSheet->player->team,
                )
            );

            return $this->sendResponse($nutritionalSheet, 'Nutritional Sheet stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating Nutritional Sheet', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/nutrition/nutritional-sheet/players/{player_id}",
     *       tags={"Nutrition"},
     *       summary="Show list Nutritional sheet by player - Lista datos de las fichas nutricional por jugador",
     *       operationId="show-nutritional-sheet",
     *       description="Return data to Nutritional sheet, param ID player require -
     *       Retorna los datos de una ficha nutricional, como parametro se requiere el ID del jugador",
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
     * Show the specified resource.
     * @param int $id
     * @return json
     */
    public function showNutritionalSheetPlayer(Request $request, Player $player)
    {
        try {
            $nutricionalSheet = $this->nutritionService->nutricionalSheetByPlayer($player->id);

            if (count($nutricionalSheet) > 0) {
                $permission = Gate::inspect('read-nutrition', $nutricionalSheet[0]['team_id']);
    
                if (!$permission->allowed()) {
                    return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
                }
            }

            return $this->sendResponse($nutricionalSheet, 'Nutricional Sheet informations by player');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Nutricional Sheet', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/nutrition/nutritional-sheet/{nutritional_sheet_id}",
     *       tags={"Nutrition"},
     *       summary="Show Nutritional sheet - Ver los datos de una ficha nutricional",
     *       operationId="show-nutritional-sheet",
     *       description="Return data to Nutritional sheet  - Retorna los datos de una ficha nutricional",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/nutritional_sheet_id" ),
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
     * @param int $id
     * @return json
     */
    public function show($id)
    {
        try {
            $nutricionalSheet = $this->nutritionalSheetRepository->findNutricionalSheetById($id);

            return $this->sendResponse($nutricionalSheet, 'Nutricional Sheet information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Nutricional Sheet', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/nutrition/nutritional-sheet/{nutritional_sheet_id}/pdf",
     *       tags={"Nutrition"},
     *       summary="Get Nutritional sheet PDF - Obtener PDF de una ficha de nutrición",
     *       operationId="pdf-nutritional-sheet",
     *       description="Return data to Nutritional sheet  - Retorna los datos de una ficha nutricional",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/nutritional_sheet_id" ),
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
    public function sheetPdf($id)
    {
        try {
            $data = $this->nutritionalSheetRepository->findNutricionalSheetById($id);

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('nutrition::sheet', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="' . sprintf('nutritional-sheet-%s.pdf', $id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Nutricional Sheet', $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/v1/nutrition/nutritional-sheet/{player_id}/pdfs",
     *       tags={"Nutrition"},
     *       summary="Get Nutritional sheet PDFs of a player - Obtener fichas PDFs de un jugador",
     *       operationId="pdfs-nutritional-sheet",
     *       description="Return data to Nutritional sheet  - Retorna los datos de una ficha nutricional",
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
    public function sheetsPdf($player_id)
    {
        try {
            $data = $this->nutritionalSheetRepository->findNutricionalSheetByPlayerId($player_id);

            if (count($data) === 0) {
                return $this->sendError('Error by retrieving Nutritional Sheet');
            }

            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('nutrition::sheets', compact('data'));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 
                    'attachment; filename="' . sprintf('nutritional-sheets-%s.pdf', $player_id) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Nutricional Sheet', $exception->getMessage());
        }
    }
}
