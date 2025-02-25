<?php

namespace Modules\InjuryPrevention\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\Club\Entities\ClubType;
use Modules\Calculator\Repositories\CalculatorItemTypeRepository;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionRepositoryInterface;
use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionWeekDayRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityAnswerHistoricalRecordRepositoryInterface;

class InjuryPreventionService
{
    use ResponseTrait, TranslationTrait;

    /**
     * @var object $injuryPreventionRepository
     */
    protected $injuryPreventionRepository;

    /**
     * @var object $injuryPreventionWeekDayRepository
     */
    protected $injuryPreventionWeekDayRepository;

    /**
     * @var object $playerRepository
     */
    protected $playerRepository;

    /**
     * @var object $calculatorItemTypeRepository
     */
    protected $calculatorItemTypeRepository;

    /**
     * @var object $calculatorEntityAnswerHistoricalRecordRepository
     */
    protected $calculatorEntityAnswerHistoricalRecordRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        InjuryPreventionRepositoryInterface $injuryPreventionRepository,
        InjuryPreventionWeekDayRepositoryInterface $injuryPreventionWeekDayRepository,
        PlayerRepositoryInterface $playerRepository,
        CalculatorItemTypeRepository $calculatorItemTypeRepository,
        CalculatorEntityAnswerHistoricalRecordRepositoryInterface $calculatorEntityAnswerHistoricalRecordRepository,
        ClubRepositoryInterface $clubRepository
    ) {
        $this->injuryPreventionRepository = $injuryPreventionRepository;
        $this->injuryPreventionWeekDayRepository = $injuryPreventionWeekDayRepository;
        $this->playerRepository = $playerRepository;
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
        $this->calculatorEntityAnswerHistoricalRecordRepository = $calculatorEntityAnswerHistoricalRecordRepository;
        $this->clubRepository = $clubRepository;
    }

    /**
     * Returns the list of all injury prevention related players
     * @return Array
     *
     * @OA\Schema(
     *  schema="InjuryPreventionPlayerListResponse",
     *  type="object",
     *  description="Returns the list of all injury prevention related players",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of all Player Related Injury Preventions"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      example={{
     *          "index": 1,
     *          "injury_prevention_id": 1,
     *          "player_id": 1,
     *          "player_image": "string",
     *          "full_name": "string",
     *          "gender_id": 1,
     *          "gender": "string",
     *          "team_id": 1,
     *          "profile_status": "string",
     *          "title": "string",
     *          "created_at": "timestamp",
     *          "is_finished": true,
     *          "total_points": 1,
     *          "total_points_code": "string"
     *      }},
     *      @OA\Items(
     *          @OA\Property(property="index", type="int64"),
     *          @OA\Property(property="injury_prevention_id", type="int64"),
     *          @OA\Property(property="player_id", type="int64"),
     *          @OA\Property(property="player_image", type="string"),
     *          @OA\Property(property="full_name", type="string"),
     *          @OA\Property(property="gender_id", type="int64"),
     *          @OA\Property(property="gender", type="string"),
     *          @OA\Property(property="team_id", type="int64"),
     *          @OA\Property(property="profile_status", type="string"),
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="created_at", type="string", format="date-time"),
     *          @OA\Property(property="is_finished", type="boolean"),
     *          @OA\Property(property="total_points", type="int64"),
     *          @OA\Property(property="total_points_code", type="string"),
     *      ),
     *  ),
     * )
     */
    public function getPlayersList($queryParams, $teamId)
    {
        try {
            $injuryPrograms = $this->injuryPreventionRepository->listPlayers($queryParams, $teamId);

            $accepted = [];

            $grouped = $injuryPrograms->groupBy('player_id');

            foreach ($grouped as $playerPrograms) {

                foreach ($playerPrograms as $program) {
                    // Parase again every row retrieved
                    $parsedValues = $this->parseCalculationItems($program->player_id);

                    // Append the parsed values to the returning item
                    $program->point = $parsedValues['total_points'];
                    $program->rank = $parsedValues['total_points_code'];

                    // Set the final resulting item into the returning array
                    $accepted[] = $program;
                }
            }

            return $accepted;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getPlayersList2($queryParams, $teamId)
    {
        try {
            $injuryPrograms = $this->injuryPreventionRepository->listPlayers($queryParams, $teamId);

            $accepted = [];

            $grouped = $injuryPrograms->groupBy('player_id');

            foreach ($grouped as $playerPrograms) {

                foreach ($playerPrograms as $program) {
                    // Parase again every row retrieved
                    $parsedValues = $this->parseCalculationItems2($program->player_id);

                    // Append the parsed values to the returning item
                    $program->point = $parsedValues['total_points'];
                    $program->rank = $parsedValues['total_points_code'];

                    // Set the final resulting item into the returning array
                    $accepted[] = $program;
                }
            }

            return $accepted;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Returns the list of all injuryPreventions related to the player
     * @return Array
     *
     * @OA\Schema(
     *  schema="InjuryPreventionListResponse",
     *  type="object",
     *  description="Returns the list of all injury prevention items related to the player.",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of Player Injury Preventions"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="integer", format="int32", example="1"),
     *      @OA\Property(property="team_id", type="integer", format="int32", example="1"),
     *      @OA\Property(property="full_name", format="string"),
     *      @OA\Property(property="alias", format="string"),
     *      @OA\Property(
     *          property="gender",
     *          type="object",
     *          example={
     *              "id": 1,
     *              "code": "string"
     *          },
     *      ),
     *      @OA\Property(property="height", format="string", example="161.30"),
     *      @OA\Property(property="weight", format="string", example="68.43"),
     *      @OA\Property(property="age", type="integer", format="int32", example="32"),
     *      @OA\Property(property="max_heart_rate", type="number", format="float", example="181.92"),
     *      @OA\Property(
     *          property="laterality",
     *          type="object",
     *          example={
     *              "id": 1,
     *              "code": "string"
     *          },
     *      ),
     *      @OA\Property(property="image", format="string"),
     *      @OA\Property(
     *          property="injury_preventions",
     *          type="array",
     *          example={{
     *              "id": 1,
     *              "title": "string",
     *              "detailed_location": "string",
     *              "description": "string",
     *              "is_finished": false,
     *              "evaluation_points": 1,
     *              "profile_status": "string",
     *              "end_date": "string",
     *              "player_id": 1,
     *              "team_staff_id": 1,
     *              "preventive_program_type_id": 1,
     *              "injury_location_id": 1,
     *              "created_at": "string",
     *              "team_staff": {
     *                  "id": 1,
     *                  "code": "string",
     *                  "full_name": "string"
     *              },
     *              "preventive_program_type": {
     *                  "id": 1,
     *                  "code": "string",
     *                  "full_name": "string"
     *              },
     *              "injury_location": {
     *                  "id": 1,
     *                  "full_name": "string"
     *              }
     *          }},
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="detailed_location", type="string"),
     *              @OA\Property(property="is_finished", type="boolean"),
     *              @OA\Property(property="evaluation_points", type="int32"),
     *              @OA\Property(property="profile_status", type="string"),
     *              @OA\Property(property="end_date", type="string", format="date"),
     *              @OA\Property(property="player_id", type="int32"),
     *              @OA\Property(property="team_staff_id", type="int32"),
     *              @OA\Property(property="preventive_program_type_id", type="int32"),
     *              @OA\Property(property="injury_location_id", type="int32"),
     *              @OA\Property(property="created_at", type="string", format="date-time"),
     *              @OA\Property(property="team_staff", type="object"),
     *              @OA\Property(property="preventive_program_type", type="object"),
     *              @OA\Property(property="injury_location", type="object"),
     *          ),
     *      ),
     *  )
     * )
     */
    public function injuryPreventionList($player)
    {
        foreach ($player->injuryPreventions as $injuryPrevention) {
            $injuryPrevention->teamStaff;
            $injuryPrevention->preventiveProgramType;
            $injuryPrevention->injuryLocation;
        }

        return [
            'id' => $player->id,
            'team_id' => $player->team_id,
            'full_name' => $player->full_name,
            'alias' => $player->alias,
            'gender' => $player->gender,
            'height' => $player->height,
            'weight' => $player->weight,
            'age' => $player->age,
            'max_heart_rate' => $player->max_heart_rate,
            'laterality' => $player->laterality,
            'image' => $player->image,
            'injury_preventions' => $player->injuryPreventions
        ];
    }

    /**
     * Stores a new injury prevention row in the database
     *
     * @return void
     */
    public function store($requestData, $playerId)
    {
        try {
            $requestData['player_id'] = (int) $playerId;

            $injuryPrevention = $this->injuryPreventionRepository->create($requestData);

            if (isset($requestData['week_days'])) {
                $this->injuryPreventionRepository->insertWeekDays(
                    $injuryPrevention->id,
                    $requestData['week_days']
                );
            }

            return $injuryPrevention;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves information about specific injury prevention
     *
     * @return object
     */
    public function find($injuryPrevention, $teamId)
    {
        $injuryPrevention->player;

        if ($injuryPrevention->player->team_id !== $teamId) {
            abort(Response::HTTP_FORBIDDEN, $this->translator('user_forbidden'));
        }

        try {
            $injuryPrevention->player->image;
            $injuryPrevention->weekDays;
            $injuryPrevention->injuryLocation;
            $injuryPrevention->teamStaff;
            $injuryPrevention->preventiveProgramType;
            $injuryPrevention->evaluationQuestionAnswers;
            $injuryPrevention->calculatorEntityAnswerHistoricalRecords;

            // TODO: replace this randomized calculation with the subjective calculation
            $codes = ['low', 'normal', 'high'];

            foreach ($injuryPrevention->calculatorEntityAnswerHistoricalRecords as $historyRecord) {
                $historyRecord->total_points_code = $codes[array_rand($codes)];

                $historyRecord->calculatorEntityItemAnswers;

                foreach ($historyRecord->calculatorEntityItemAnswers as $answer) {
                    $answer->calculatorEntityItemPointValue;
                }
            }

            return $injuryPrevention;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about a injury prevention
     *
     * @return object
     */
    public function update($requestData, $injuryPrevention)
    {
        try {
            if (isset($requestData['week_days'])) {
                $this->injuryPreventionRepository->deleteWeekDays($injuryPrevention->id);

                $this->injuryPreventionRepository->insertWeekDays(
                    $injuryPrevention->id,
                    $requestData['week_days']
                );
            }

            return $this->injuryPreventionRepository->update($requestData, $injuryPrevention);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes a injuryPrevention information from database
     *
     * @return boolean
     */
    public function destroy($injuryPrevention)
    {
        try {
            return $this->injuryPreventionRepository->delete($injuryPrevention->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     *
     */
    private function parseCalculationItems($injuryPreventionId = 0)
    {
        $result = [
            'total_points' => null,
            'total_points_code' => null,
        ];

        $injuryProgram = $this->injuryPreventionRepository->findOneBy([
            'id' => $injuryPreventionId
        ]);

        if (!$injuryProgram) {
            return $result;
        }

        $lastCalculation = $injuryProgram->calculatorEntityAnswerHistoricalRecords->first();

        if (!$lastCalculation) {
            return $result;
        }

        return [
            'total_points' => $lastCalculation->total_points,
            'total_points_code' => $this->calculatorItemTypeRepository->getItemType($lastCalculation->total_points)
        ];
    }

    /**
     *
     */
    private function parseCalculationItems2($player_id = 0)
    {
        $result = [
            'total_points' => null,
            'total_points_code' => null,
        ];

        $calculatorResults = $this->calculatorEntityAnswerHistoricalRecordRepository->findBy(
            ['entity_id' => $player_id],
            ['created_at' => 'desc']
        );

        if ($calculatorResults->count() == 0) {
            return $result;
        }

        $lastCalculation = $calculatorResults->first();

        if (!$lastCalculation) {
            return $result;
        }

        return [
            'total_points' => $lastCalculation->total_points,
            'total_points_code' => $this->calculatorItemTypeRepository->getItemType($lastCalculation->total_points)
        ];
    }


    /**
     * Retrieve all injuries prevention create by user
     */
    public function allInjuriesPreventionByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_injuries_prevention = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->injuries_prevention = $this->injuryPreventionRepository->findBy([
                        'player_id' => $player->id
                    ]);

                    return $player->injuries_prevention->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_injuries_prevention' => $total_injuries_prevention ?? 0
        ];
    }
}
