<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Player\Services\PlayerContractService;
use Modules\Player\Http\Requests\StorePlayerContractRequest;
use Modules\Player\Http\Requests\UpdatePlayerContractRequest;
use Modules\Player\Repositories\Interfaces\PlayerContractRepositoryInterface;

class PlayerContractController extends BaseController
{
    use ResponseTrait;

    /**
     * @var $playerContractService
     */
    protected $playerContractService;

    /**
     * @var $playerContractRepository
     */
    protected $playerContractRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        PlayerContractService $playerContractService,
        PlayerContractRepositoryInterface $playerContractRepository
    ) {
        $this->playerContractService = $playerContractService;
        $this->playerContractRepository = $playerContractRepository;
    }

    /**
     * Display a listing of the player's contracts.
     * @return Response
     * 
     * @OA\Get(
     *      path="/api/v1/players/{player_id}/contracts",
     *      tags={"Player/Contracts"},
     *      summary="Player contract index list - Listado de contractos de jugadores",
     *      operationId="player-contract-index",
     *      description="Shows a list of contract of players - Muestra el listado de contratos de jugadores",
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
    public function index($playerId)
    {   
        $contracts = $this->playerContractRepository->findBy([
            'player_id' => $playerId
        ]);

        foreach ($contracts as $contract) {
            $contract->image;
        }

        return $this->sendResponse($contracts, 'Player Contracts List');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param Int $id
     * @return Response
     * 
     *  @OA\Post(
     *      path="/api/v1/players/{player_id}/contracts",
     *      tags={"Player/Contracts"},
     *      summary="Store a new contract to player - Inserta informacion de un contrato a jugador",
     *      operationId="player-contract-store",
     *      description="Stores a new contract to player - Agrega un nuevo contrato a jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/StorePlayerContractRequest")
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
    public function store(StorePlayerContractRequest $request, $id)
    {
        try {
            $contract_data = $request->all();

            $contract_data['player_id'] = $id;
            
            $contract = $this->playerContractService->insertPlayerContract($contract_data);
    
            return $this->sendResponse($contract, 'Player Contract Stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating a new contract', $exception->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     * 
     *   @OA\Get(
     *      path="/api/v1/players/contracts/{contract_id}",
     *      tags={"Player/Contracts"},
     *      summary="Player contract detail - Detalle de contracto de jugador",
     *      operationId="player-contract-show",
     *      description="Shows a detail of contract of player - Muestra el detalle de contrato de jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ), 
     *      @OA\Parameter( ref="#/components/parameters/contract_id" ),
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
        $contract = $this->playerContractRepository->findOneBy([
            'id' => $id
        ]);

        if (!$contract) {
            return $this->sendError('Contract not found', NULL, Response::HTTP_NOT_FOUND);
        }

        $contract->image;

        return $this->sendResponse($contract, 'Player Contract Information');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     * 
     *  @OA\Post(
     *      path="/api/v1/players/{player_id}/contracts/{contract_id}",
     *      tags={"Player/Contracts"},
     *      summary="Update a contract to player - Actualiza informacion de un contrato a jugador",
     *      operationId="player-contract-update",
     *      description="Update a contract to player - Actualiza un contrato a jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ),
     *      @OA\Parameter( ref="#/components/parameters/player_id" ),
     *      @OA\Parameter( ref="#/components/parameters/contract_id" ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdatePlayerContractRequest")
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
    public function update(UpdatePlayerContractRequest $request, $playerId, $contractId)
    {
        try {
            $contract_data = $request->all();
    
            $contract_data['player_id'] = $playerId;

            $contract = $this->playerContractService->updatePlayerContract($contract_data, $contractId);

            return $this->sendResponse($contract, 'Player contract updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating contract', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * 
     *    @OA\delete(
     *      path="/api/v1/players/contracts/{contract_id}",
     *      tags={"Player/Contracts"},
     *      summary="Player contract delete - Borra contracto de jugador",
     *      operationId="player-contract-delete",
     *      description="Delete of contract of player - Borra contrato de jugador",
     *      security={{"bearerAuth": {} }},
     *      @OA\Parameter( ref="#/components/parameters/_locale" ), 
     *      @OA\Parameter( ref="#/components/parameters/contract_id" ),
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
    public function destroy($id)
    {
        try {
            $this->playerContractRepository->delete($id);

            return $this->sendResponse(NULL, 'Player contract deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting player', $exception->getMessage());
        }
    }
}
