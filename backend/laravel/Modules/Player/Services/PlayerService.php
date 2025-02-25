<?php

namespace Modules\Player\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Club\Entities\ClubType;
use Modules\Family\Services\FamilyService;
use Modules\Activity\Events\ActivityEvent;
use Modules\Injury\Services\InjuryService;
use Modules\Address\Services\AddressService;
use Modules\Generality\Services\ResourceService;
use Modules\Training\Services\TrainingLoadService;
use Modules\Calculator\Services\CalculatorService;
use Modules\EffortRecovery\Services\EffortRecoveryService;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Health\Repositories\Interfaces\HealthRepositoryInterface;
use Modules\Scouting\Services\Interfaces\PlayerStatisticServiceInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchPlayerRepositoryInterface;

class PlayerService
{
    use ResponseTrait, ResourceTrait, TranslationTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $playerHealthRepository
     */
    protected $playerHealthRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;
    
    /**
     * @var $resourceRepository
     */
    protected $matchPlayerRepository;

    /**
     * @var $resourceRepository
     */
    protected $competitionMatchRepository;

    /**
     * Repository
     * @var $scoutingResultRepository
     */
    protected $scoutingResultRepository;
    
    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var $playerStatisticService
     */
    protected $playerStatisticService;

    /**
     * @var $trainingLoadService
     */
    protected $trainingLoadService;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var object
     */
    protected $addressService;

    /**
     * @var object
     */
    protected $familyService;
   
    /**
     * @var object
     */
    protected $injuryService;

    /**
     * @var $calculatorService
     */
    protected $calculatorService;

    /**
     * @var $effortService
     */
    protected $effortService;

    /**
     * Creates a new service instance
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        UserRepositoryInterface $userRepository,
        HealthRepositoryInterface $playerHealthRepository,
        ResourceRepositoryInterface $resourceRepository,
        CompetitionMatchPlayerRepositoryInterface $matchPlayerRepository,
        CompetitionMatchRepositoryInterface $competitionMatchRepository,
        ScoutingResultRepositoryInterface $scoutingResultRepository,
        ClubRepositoryInterface $clubRepository,
        TrainingLoadService $trainingLoadService,
        ResourceService $resourceService,
        AddressService $addressService,
        FamilyService $familyService,
        InjuryService $injuryService,
        CalculatorService $calculatorService,
        EffortRecoveryService $effortService,
        PlayerStatisticServiceInterface $playerStatisticService
    ) {
        $this->playerRepository = $playerRepository;
        $this->userRepository = $userRepository;
        $this->playerHealthRepository = $playerHealthRepository;
        $this->resourceRepository = $resourceRepository;
        $this->matchPlayerRepository = $matchPlayerRepository;
        $this->competitionMatchRepository = $competitionMatchRepository;
        $this->scoutingResultRepository = $scoutingResultRepository;
        $this->clubRepository = $clubRepository;
        $this->trainingLoadService = $trainingLoadService;
        $this->resourceService = $resourceService;
        $this->addressService = $addressService;
        $this->familyService = $familyService;
        $this->injuryService = $injuryService;
        $this->calculatorService = $calculatorService;
        $this->effortService = $effortService;
        $this->playerStatisticService = $playerStatisticService;
    }

    /**
     * Retrieve all players create by user
     */
    public function allPlayersByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_players = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->count();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_teams' => $total_players ?? 0
        ];
    }

    /**
     * Retrieve resumes of players
     *
     * @param $request
     * @param $teamId
     */
    public function resume($teamId, $playerId)
    {
        $player = $this->playerRepository->findOneBy([
            'team_id' => $teamId,
            'id' => $playerId
        ]);

        if (!$player) {
            throw new Exception('Player not found', Response::HTTP_NOT_FOUND);
        }

        $player->age;
        $player->bmi;
        $player->max_heart_rate;
        $player->gender;
        $player->team;
        $player->position;
        $player->position_spec;
        $player->image;
        $player->psychologyReports;
        $player->address;
        $player->family;
        $player->family->members ?? null;
        $player->family->address ?? null;

        $last_match = $this->competitionMatchRepository->lastMatchPlayer($player->id);

        if($last_match) {
            $scouting = $last_match->scouting;

            $last_match->score = null;

            if($scouting) {
                $results = $this->scoutingResultRepository->findOneBy([
                    'scouting_id' => $scouting->id
                ]);
    
                $last_match->score = $results->data->score ?? null;
            }
        }

        $statistics = $this->playerStatisticService->byPlayer($player);

        return [
            'player' => $player,
            'matches' => $this->matchPlayerRepository->countMatchesPlayer($player->id),
            'last_match' => $last_match,
            'health_status' => $this->hasHealtStatus($player),
            'lastet_injury' => $this->injuryService->lastInjuryByPlayer($player->id),
            'injuries_history' => $this->injuryService->injuriesLocationsByPlayer($player->id),
            'statistics' => $statistics['general_statistics']
        ];
    }

    /**
     * Retrieve resumes of players
     *
     * @param $request
     * @param $teamId
     */
    public function resumes($request, $teamId)
    {
        $players = $this->listPlayers($teamId, ['full_name' => 'ASC']);

        foreach ($players as $player) {
            $player->makeHidden([
                'profile', 'performance_assessment', 'agents', 'gender_identity_id', 'team'
            ]);
            $player->matches = $this->matchPlayerRepository->countMatchesPlayer($player->id);

            $rpe_last_match = $this->matchPlayerRepository->rpeLastMatchPlayer($player->id);
          
            $player->rpe_last_match = $rpe_last_match->perceptEffort ?? null;

            $player->injury_risk = $this->calculatorService->lastInjuryRisk($player->id);

            $player->effort_recovery = $this->effortService->lastEffortRecoveryPlayer($player->id);

            $player->training_load = $this->trainingLoadService->trainingLoadActual(Player::class, $player->id);
        }

        return $players;
    }

    /**
     * Retrieves the list of players related to a team
     *
     * @return array
     */
    public function index($request, $teamId)
    {
        try {
            $orderBy = [
                'full_name' => 'ASC'
            ];

            if (isset($request['order'])) {
                $orderBy['full_name'] = $request['order'];
            }

            return $this->listPlayers($teamId, $orderBy);
        } catch (Exception $exception) {
            throw $exception;
        }
    }


    /**
     * Inserts player information into the database
     *
     * @return object
     */
    public function store($playerData, $playerAddressData, $motherData, $fatherData,
        $addressData, $image, $statusId, $user = null) 
    {
        try {
            DB::beginTransaction();

            // Stores the image in case is sent
            if (isset($image)) {
                $dataResource = $this->uploadResource('/players', $image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $playerData['image_id'] = $resource->id;
                }
            }

            // Stores a new player and registers its information
            $player = $this->playerRepository->create($playerData);

            $this->addressService->store($playerAddressData, $player);

            // Stores a family registry
            $family = $this->familyService->store($statusId, $player);
            $parsedFamilyAddress = $this->parseMemberData($addressData, 'family_address');
            $this->addressService->store($parsedFamilyAddress, $family);

            // Parses mother information and stores it into database
            $parsedMotherData = $this->parseMemberData($motherData, 'mother');
            $this->familyService->manageMember($family, $parsedMotherData, 'mother');

            // Parses father information and stores it into the database
            $parsedFatherData = $this->parseMemberData($fatherData, 'father');
            $this->familyService->manageMember($family, $parsedFatherData, 'father');

            if (isset($user)) {
                event(
                    new ActivityEvent($user, $player->team->club, 'player_created', $player->team, $player)
                );
            }

            DB::commit();
            return $player;
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    /**
     * Retrieves information about specific player
     *
     * @return object
     */
    public function show($playerId)
    {
        try {
            $player = $this->playerRepository->findOneBy([
                'id' => $playerId
            ]);

            if (!$player) {
                throw new Exception('Player not found', Response::HTTP_NOT_FOUND);
            }

            $player->age;
            $player->bmi;
            $player->max_heart_rate;
            $player->gender;
            $player->team;
            $player->position;
            $player->position_spec;
            $player->image;
            $player->psychologyReports;
            $player->address;
            $player->family;
            $player->family->members ?? null;
            $player->family->address ?? null;

            return $player;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about player in database
     *
     * @return bool|object
     */
    public function update($playerId, $playerData, $playerAddressData, $motherData,
        $fatherData, $addressData, $image, $statusId, $user = null) 
    {
        try {
            DB::beginTransaction();

            $player = $this->findPlayer($playerId);

            $deletableImageId = null;

            if (isset($image)) {
                $dataResource = $this->uploadResource('/players', $image);
                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $playerData['image_id'] = $resource->id;
                }

                $deletableImageId = $player->image_id;
            }

            // Do a basic update on the player information
            $this->playerRepository->update($playerData, $player);

            // Update the address
            $this->addressService->update($playerAddressData, $player);

            // In case the player has no previous family it stores a new registry
            $family = !$player->family
                ? $this->familyService->store($statusId, $player)
                : $player->family;

            $parsedFamilyAddress = $this->parseMemberData($addressData, 'family_address');

            if (!$player->family->address) {
                $this->addressService->store($parsedFamilyAddress, $family);
            } else {
                $this->addressService->update($parsedFamilyAddress, $player->family);
            }

            // Parses mother information and manages it into database
            $parsedMotherData = $this->parseMemberData($motherData, 'mother');
            $this->familyService->manageMember($family, $parsedMotherData, 'mother');

            // Parses father information and manages it into the database
            $parsedFatherData = $this->parseMemberData($fatherData, 'father');
            $this->familyService->manageMember($family, $parsedFatherData, 'father');

            if (isset($user)) {
                event(
                    new ActivityEvent($user, $player->team->club, 'player_updated', $player->team, $player->getBasicAtributes())
                );
            }

            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            DB::commit();

            return $this->findPlayer($playerId);
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    /**
     * Deletes a player
     *
     * @return bool|object
     */
    public function delete($playerId, $user = null)
    {
        try {
            $player = $this->findPlayer($playerId);

            if ($user) {
                event(
                    new ActivityEvent($user, $player->team->club, 'player_deleted', $player->team, $player->getBasicAtributes())
                );
            }

            return $this->playerRepository->delete($player->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Keeps same values but replaces item keys by removing the string
     * sent by $type parameter
     *
     * @param array $data
     * @param string $type
     * @return array
     */
    private function parseMemberData($data, $type)
    {
        $parsedData = [];

        foreach ($data as $key => $value) {
            $parsedKey = str_replace($type . '_', '', $key);
            $parsedData[$parsedKey] = $value;
        }

        return $parsedData;
    }

    /**
     * Return a player item object
     *
     * @return object
     */
    private function findPlayer($id)
    {
        $player = $this->playerRepository->findOneBy([
            'id' => $id
        ]);

        if (!$player) {
            throw new Exception('Player not found', Response::HTTP_NOT_FOUND);
        }

        return $player;
    }

    /**
     * Retreieve list players by team
     * @param $teamId
     * @param $orderBy
     */
    private function listPlayers($teamId, $orderBy)
    {
        $players = $this->playerRepository->findBy([
            'team_id' => $teamId
        ], $orderBy);

        foreach ($players as $player) {
            $player->team;
            $player->position;
            $player->position_spec;
            $player->image;
        }

        return $players;
    }

     /**
     * Verified healt status player
     *
     * @param $player_id
     */
    private function hasHealtStatus($player)
    {
        $diseases = $player->diseases->count();
        $allergies = $player->allergies->count();
        $body_areas = $player->bodyAreas->count();
        $physical_problems = $player->physicalProblems->count();
        $medicine_types = $player->medicineTypes->count();
        $surgeries = $player->surgeries->count();

        return $diseases > 0 || $allergies > 0 ||
                $body_areas > 0 || $physical_problems > 0 ||
                $medicine_types > 0 || $surgeries > 0;
    }
}
