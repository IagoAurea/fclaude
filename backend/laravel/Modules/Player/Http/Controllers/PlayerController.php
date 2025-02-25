<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Player\Entities\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Player\Services\PlayerService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Services\ResourceService;
use Modules\Player\Http\Requests\StorePlayerRequest;
use Modules\Player\Http\Requests\UpdatePlayerRequest;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;


class PlayerController extends BaseController
{
    use TranslationTrait;

    const MOTHER_INPUT_VALUES = [
        'mother_email', 'mother_full_name', 'mother_phone', 'mother_mobile_phone'
    ];

    const FATHER_INPUT_VALUES = [
        'father_email', 'father_full_name', 'father_phone', 'father_mobile_phone'
    ];

    const PLAYER_ADDRESS_VALUES = [
        'street',
        'city',
        'postal_code',
        'country_id',
        'province_id',
        'phone',
        'mobile_phone',
    ];

    const FAMILY_ADDRESS_VALUES = [
        'family_address_street',
        'family_address_city',
        'family_address_postal_code',
        'family_address_country_id',
        'family_address_province_id'
    ];

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $playerService
     */
    protected $playerService;

    /**
     * @var $playerService
     */
    protected $playerRepository;

    public function __construct(
        ResourceService $resourceService,
        PlayerService $playerService,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->resourceService = $resourceService;
        $this->playerService = $playerService;
        $this->playerRepository = $playerRepository;
    }



     /**
     * Retrieve all players created by user
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/api/v1/players/list/user",
     *  tags={"Player"},
     *  summary="List all players of user authenticate - Lista todos los jugadores creado por el usuario",
     *  operationId="list-players-user",
     *  description="List all players of user authenticate -
     *  Lista todos los jugadores creado por el usuario",
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
    public function getAllPlayersUser()
    {
        $players = $this->playerService->allPlayersByUser(Auth::id());

        return $this->sendResponse($players, 'List all players of user');
    }

    /**
     * Function to list all players related to a specific team with statistic
     * @return Response
     *
     * @OA\Get(
     *      path="/api/v1/players/{team_id}/resumes",
     *      tags={"Player"},
     *      summary="Player Index List Resume - Listado de Jugadores Resume",
     *      operationId="player-index-resume",
     *      description="Shows a list of players depending on the team with statistic
     *      - Muestra el listado de jugadores de un equipo con estadisticas",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/team_id" ),
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
     */
    public function resumes(Request $request, $teamId)
    {
        $permission = Gate::inspect('list-player', $teamId);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $players = $this->playerService->resumes($request->all(), $teamId);

        return $this->sendResponse($players, 'List resumes players');
    }

    /**
     * Retrieve detail player
     *
     * @param $teamId
     * @param $playerId
     *
     *   @OA\Get(
     *      path="/api/v1/players/{team_id}/resume/{player_id}",
     *      tags={"Player"},
     *      summary="Player Detail Resume - Resume de detalle de Jugador",
     *      operationId="player-show-resume",
     *      description="Shows resume of player with statistic
     *      - Muestra resumen del detalle de jugador de con estadisticas",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/team_id" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     */
    public function resume($teamId, $playerId)
    {
        try {
            $player = $this->playerService->resume($teamId, $playerId);

            return $this->sendResponse($player, 'Resume player');

        } catch (Exception $exception) {
            return $this->sendError('Error by retieving player resume', $exception->getMessage());
        }
    }

    /**
     *  Function to list all players related to a specific team
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/players/{team_id}",
     *      tags={"Player"},
     *      summary="Player Index List - Listado de Jugadores",
     *      operationId="player-index",
     *      description="Shows a list of players depending on the team - Muestra el listado de jugadores de un equipo",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/team_id" ),
     *      @OA\Parameter( ref="#/components/parameters/order" ),
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
     */
    public function index(Request $request, $teamId)
    {
        $players = $this->playerService->index($request->all(), $teamId);

        return $this->sendResponse($players, 'List Players');
    }

    /**
     *  Function to store a new player into the database
     *  @return Response
     *
     *  @OA\Post(
     *      path="/api/v1/players",
     *      tags={"Player"},
     *      summary="Store a new Player - Inserta informacion de Jugador",
     *      operationId="player-store",
     *      description="Stores a new player into the database - Agrega un nuevo jugador a la base de datos",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/StorePlayerRequest")
     *          )
     *      ),
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
     */
    public function store(StorePlayerRequest $request)
    {
        $permission = Gate::inspect('store-player', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $motherData = $request->only(self::MOTHER_INPUT_VALUES);
            $fatherData = $request->only(self::FATHER_INPUT_VALUES);
            $familyAddressData = $request->only(self::FAMILY_ADDRESS_VALUES);
            $playerAddressData = $request->only(self::PLAYER_ADDRESS_VALUES);
            $playerData =  $request->except($this->getPlayerExceptedValues());

            $player = $this->playerService->store(
                $playerData,
                $playerAddressData,
                $motherData,
                $fatherData,
                $familyAddressData,
                $request->image,
                $request->parents_marital_status_id,
                Auth::user()
            );

            return $this->sendResponse($player, $this->translator('player_created'));
        } catch (Exception $exception) {
            return $this->sendError('Error by storing player', $exception->getMessage());
        }
    }

    /**
     *  Retrieves full information of a specific player
     *  @param Int $id
     *  @return Response
     *
     *  @OA\Get(
     *      path="/api/v1/players/{player_id}",
     *      tags={"Player"},
     *      summary="Show Player - Mostrar Jugador",
     *      operationId="player-show",
     *      description="Shows player's information - Muestra informacion de jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
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
     */
    public function show($id)
    {
        try {
            $player = $this->playerService->show($id);

            $permission = Gate::inspect('read-player', $player->team_id);

            if (!$permission->allowed()) {
                return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
            }

            return $this->sendResponse($player, 'Player Information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retieving player information', $exception->getMessage());
        }
    }

    /**
     *  Updates information about an specific player
     *
     *  @param Request $request
     *  @param Int $id
     *  @return Response
     *
     *  @OA\Post(
     *      path="/api/v1/players/{player_id}",
     *      tags={"Player"},
     *      summary="Updates player information - Actualiza informacion de jugador",
     *      operationId="player-update",
     *      description="Updates an existent player from database - Actualiza un jugador existente de la base de datos",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdatePlayerRequest")
     *          )
     *      ),
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
     */
    public function update(UpdatePlayerRequest $request, $id)
    {
        $permission = Gate::inspect('update-player', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $motherData = $request->only(self::MOTHER_INPUT_VALUES);
            $fatherData = $request->only(self::FATHER_INPUT_VALUES);
            $familyAddressData = $request->only(self::FAMILY_ADDRESS_VALUES);
            $playerAddressData = $request->only(self::PLAYER_ADDRESS_VALUES);
            $playerData =  $request->except($this->getPlayerExceptedValues());

            $player = $this->playerService->update(
                $id,
                $playerData,
                $playerAddressData,
                $motherData,
                $fatherData,
                $familyAddressData,
                $request->image,
                $request->parents_marital_status_id,
                Auth::user()
            );

            return $this->sendResponse($player, $this->translator('player_updated'));
        } catch (Exception $exception) {
            return $this->sendError('Error by updating existent player', $exception->getMessage());
        }
    }


    /**
     * Deletes a player record
     * @param $id
     * @return Response
     *
     *  @OA\Delete(
     *      path="/api/v1/players/{player_id}",
     *      tags={"Player"},
     *      summary="Delete Player - Eliminar Jugador",
     *      operationId="player-delete",
     *      description="Deletes an existent player - Elimina un jugador existente",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter(
     *          ref="#/components/parameters/player_id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          ref="#/components/responses/reponseSuccess"
     *      ),
     *      @OA\Response(
     *          response="401",
     *          ref="#/components/responses/notAuthenticated"
     *      ),
     *      @OA\Response(
     *          response="404",
     *          ref="#/components/responses/resourceNotFound"
     *      )
     *  )
     */
    public function destroy(Player $player)
    {
        $permission = Gate::inspect('delete-player', $player->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $deleted = $this->playerService->delete($player->id, Auth::user());

            return $this->sendResponse($deleted, 'Player deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting player', $exception->getMessage());
        }
    }

    /**
     * Return an array with excepted values
     *
     * @return array
     */
    private function getPlayerExceptedValues()
    {
        return array_merge(
            self::MOTHER_INPUT_VALUES,
            self::FATHER_INPUT_VALUES,
            self::FAMILY_ADDRESS_VALUES,
            self::PLAYER_ADDRESS_VALUES,
            ['image', 'parents_marital_status_id']
        );
    }
}
