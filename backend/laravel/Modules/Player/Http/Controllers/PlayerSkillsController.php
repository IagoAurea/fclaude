<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\Player\Services\PlayerSkillsService;
use Modules\Player\Http\Requests\StorePlayerSkillsRequest;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PunctuationRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerSkillsRepositoryInterface;

class PlayerSkillsController extends BaseController
{
   
    /**
     * @var $playerSkillsRepository
     */
    protected $playerSkillsRepository;

    /**
     * @var $punctuationRepository
     */
    protected $punctuationRepository;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $playerSkillsService
     */
    protected $playerSkillsService;

    public function __construct(
        PlayerSkillsRepositoryInterface $playerSkillsRepository,
        PlayerSkillsService $playerSkillsService,
        PlayerRepositoryInterface $playerRepository,
        PunctuationRepositoryInterface $punctuationRepository
    )
    {
        $this->playerSkillsRepository = $playerSkillsRepository;
        $this->playerSkillsService = $playerSkillsService;
        $this->playerRepository = $playerRepository;
        $this->punctuationRepository = $punctuationRepository;
    }
    

    /**
    * @OA\Post(
    *       path="/api/v1/players/assessment/{player_id}",
    *       tags={"Player"},
    *       summary="Stored Skills to player - guardar Skills a jugador",
    *       operationId="skills-store-player",
    *       description="Store a new skills to player- Guarda un nuevo  Skill a jugador",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/player_id" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/StorePlayerSkillsRequest")
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
     * @param StorePlayerSkillsRequest $request
     * @return Response
     */
    public function store(StorePlayerSkillsRequest $request, $player_id)
    {

            $playersSkills =  $this->playerSkillsService->createOrUpdateSkills($request->skills,$player_id);

            if (!$playersSkills['success']) {
                return $this->sendError('Error by creating Players Skills assessment',$playersSkills['message']);
            }

            return $this->sendResponse($playersSkills['data'], 'Player Punctuation stored', Response::HTTP_CREATED);
    }


    /**
    * @OA\Get(
    *       path="/api/v1/players/assessment/{player_id}",
    *       tags={"Player"},
    *       summary="Show skills to player - Ver los datos de un Skills del jugador",
    *       operationId="show-skills-player",
    *       description="Return data to skills to player - Retorna los datos de un Skills del jugador",
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
     * @param int $player_id
     * @return Response
     */
    public function show($player_id)
    {
        try {

            $player =  $this->playerRepository->find($player_id);

            if (!$player) return $this->sendError('Player not found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND);

            $skills = $this->playerSkillsRepository->findSkillsByPLayer($player_id);

            if(!$skills) {
                return $this->sendError("Error", "Skills By player not found", Response::HTTP_NOT_FOUND);
            }

            $data['skills'] = $skills;

            $data['performance_assessment'] = $player->performance_assessment;

            $data['performance_assessment_punctuation'] = $player->performance_assessment ? 
                $this->punctuationRepository->getPunctuationPerfomanceAssessment($player->performance_assessment):
                NULL;

            return $this->sendResponse($data, 'Skills By player information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Skills By player', $exception->getMessage());
        }
    }

}
