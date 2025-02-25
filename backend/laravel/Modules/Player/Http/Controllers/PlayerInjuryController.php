<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Injury\Entities\Injury;
use Modules\Player\Entities\Player;
use Modules\Injury\Services\InjuryService;
use App\Http\Controllers\Rest\BaseController;
//Requests
use Modules\Player\Http\Requests\StorePlayerInjuryRequest;


class PlayerInjuryController extends BaseController
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
    *       path="/api/v1/players/injuries/{player_id}",
    *       tags={"Player"},
    *       summary="Show data injuries player - Ver datos de lesiones de jugador",
    *       operationId="list-injuries",
    *       description="Return data of injuries player - Retorna datos de lesiones del jugador",
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
     * Retrieve a list of all the injuries registered to the player
     *
     * @return Response
     */
    public function index(Player $player) {
        try {
            $injuries = $this->injuryService->resumeInjuriesByPlayer($player->id);

            return $this->sendResponse($injuries, 'List of Player Injuries');
        } catch (Exception $exception) {
            return $this->sendError('Cannot retrieve player injury list', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/players/injuries/{player_id}",
     *       tags={"Player"},
     *       summary="Create Player Injury - Crear Lesion a Jugador",
     *       operationId="injury-player-store",
     *       description="Create player new injury - Crear una nueva lesion a un jugador",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/player_id" ),
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
    public function store(StorePlayerInjuryRequest $request, Player $player)
    {
        try {
            $injury_data = $request->except('_locale');

            $injury_data['entity_id'] = $player->id;
            $injury_data['entity_type'] = Player::class;

            $injury = $this->injuryService->store($injury_data);
     
            return $this->sendResponse($injury, $this->translator('player_injury_stored'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by storing injury', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/players/injuries/show/{player_injury_id}",
    *       tags={"Player"},
    *       summary="Show detail injury - Ver detalle de lesion",
    *       operationId="show-injury",
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
     * Retrieves an injury related to a player
     *
     * @return Response
     */
    public function show(Injury $injury)
    {
        $injury->mechanism;
        $injury->severity;
        $injury->location;
        $injury->type;
        $injury->typeSpec;
        $injury->areaBody;
        $injury->extrinsicFactor;
        $injury->intrinsicFactor;
        $injury->clinicalTestTypes;
        $injury->injurySituation;

        return $this->sendResponse($injury, 'Player Injury Information');
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

            return $this->sendResponse(null, $this->translator('player_injury_deleted'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting injury', $exception->getMessage());
        }
    }
}
