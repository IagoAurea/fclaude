<?php

namespace Modules\Alumn\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Injury\Entities\Injury;
use Modules\Injury\Services\InjuryService;
use App\Http\Controllers\Rest\BaseController;

class AlumnInjuryController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $injuryService
     */
    protected $injuryService;

    /**
     * Creates a new controller instance
     */
    public function __construct(InjuryService $injuryService) {
        $this->injuryService = $injuryService;
    }

     /**
    * @OA\Get(
    *       path="/api/v1/alumns/injuries/{alumn_id}",
    *       tags={"Alumn"},
    *       summary="Show data injuries alumn - Ver datos de lesiones de alumno",
    *       operationId="list-injuries-alumn",
    *       description="Return data of injuries alumn - Retorna datos de lesiones del alumno",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/alumn_id" ),
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
     * Retrieve a list of all the injuries registered to the alumn
     *
     * @return Response
     */
    public function index(Alumn $alumn) {
        try {
            $injuries = $this->injuryService->resumeInjuriesByAlumn($alumn->id);

            return $this->sendResponse($injuries, 'List of alumn injuries');
        } catch (Exception $exception) {
            return $this->sendError('Cannot retrieve alumn injury list', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/alumns/injuries/{alumn_id}",
     *       tags={"Alumn"},
     *       summary="Create Alumn Injury - Crear Lesion a Alumno",
     *       operationId="injury-alumn-store",
     *       description="Create alum new injury - Crear una nueva lesion a un alumno",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/alumn_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StorePlayerInjuryRequest")
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
     * Store a new injury related to an user
     *
     * @return Response
     */
    public function store(Request $request, Alumn $alumn)
    {
        try {
            $injury_data = $request->except('_locale');

            $injury_data['entity_id'] = $alumn->id;
            $injury_data['entity_type'] = Alumn::class;

            $injury = $this->injuryService->store($injury_data);
    
            return $this->sendResponse($injury, $this->translator('alumn_injury_store'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing injury', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/alumns/injuries/show/{injury_id}",
    *       tags={"Alumn"},
    *       summary="Show detail injury - Ver detalle de lesion",
    *       operationId="show-injury-alumn",
    *       description="Return data of injury - Retorna dato de lesion",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/injury_id" ),
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
     * Retrieves an injury related to a alumn
     *
     * @return Response
     */
    public function show(Injury $injury)
    {
        $injury->mechanism;
        $injury->severity;
        $injury->location;
        $injury->location->image ?? null;
        $injury->type;
        $injury->typeSpec;
        $injury->typeSpec->image ?? null;
        $injury->areaBody;
        $injury->extrinsicFactor;
        $injury->intrinsicFactor;
        $injury->clinicalTestTypes;
        $injury->injurySituation;
        $injury->severity_location =
            $this->injuryService->severityLocation($injury->injury_severity_id, $injury->injury_location_id);

        return $this->sendResponse($injury, 'Alumn Injury Information');
    }

    /**
     * Deletes an existent injury
     *
     * @return Response
     */
    public function destroy(Injury $injury)
    {
        try {
            $this->injuryService->destroy($injury);

            return $this->sendResponse(null, 'Injury deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting injury', $exception->getMessage());
        }
    }
}
