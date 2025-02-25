<?php

namespace Modules\EffortRecovery\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Traits\TranslationTrait;
use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryProgramStrategyRepositoryInterface;

class EffortRecoveryService
{
    use ResponseTrait, TranslationTrait;

    /**
     * @var object $effortRecoveryRepository
     */
    protected $effortRecoveryRepository;

    /**
     * @var object $programStrategyRepository
     */
    protected $programStrategyRepository;

    /**
     * @var object $playerRepository
     */
    protected $playerRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        EffortRecoveryRepositoryInterface $effortRecoveryRepository,
        EffortRecoveryProgramStrategyRepositoryInterface $programStrategyRepository,
        PlayerRepositoryInterface $playerRepository,
        ClubRepositoryInterface $clubRepository
    ) {
        $this->effortRecoveryRepository = $effortRecoveryRepository;
        $this->programStrategyRepository = $programStrategyRepository;
        $this->playerRepository = $playerRepository;
        $this->clubRepository = $clubRepository;
    }

    /**
     * Retrieve all efforts recovery create by players
     */
    public function allEffortsRecoveryByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_efforts_recovery = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->tests = $this->effortRecoveryRepository->findBy([
                        'player_id' => $player->id
                    ]);

                    return $player->tests->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_efforts_recovery' => $total_efforts_recovery ?? 0
        ];
    }

    /**
     * Retrieve last effort recovery by player
     */
    public function lastEffortRecoveryPlayer($player_id)
    {
        $lastEffort = $this->effortRecoveryRepository->lastEffortRecoveryByPlayer($player_id);

        $dataEffort = null;

        if (isset($lastEffort->latestQuestionnaireHistory)) {
            $dataEffort['calculated_status'] =
                $this->translator($lastEffort->latestQuestionnaireHistory->calculatedStatus);
            $dataEffort['calculated_code'] = $lastEffort->latestQuestionnaireHistory->calculatedStatus;
        }

        return $dataEffort;
    }

    /**
     * Lists all the players related to a team
     *
     * @return array
     */
    public function listPlayers($teamId, $queryParams)
    {
        $players = $this->playerRepository->lastEffortRecovery($teamId, $queryParams);

        foreach ($players as $player) {
            $effortRecovery = $player['latestEffortRecovery'];

            if (is_null($effortRecovery)) {
                continue;
            }

            $effortRecovery['answers'] = [];
            $effortRecovery['calculated_status'] = null;
            $effortRecovery['calculated_code'] = null;

            $effort = $this->effortRecoveryRepository->findOneBy([
                'id' => $effortRecovery->id
            ]);

            $answerData = [];

            if ($effort->latestQuestionnaireHistory) {
                foreach ($effort->latestQuestionnaireHistory->answers as $answer) {
                    $answerData[] = [
                        'id' => $answer->id,
                        'name' => $answer->name,
                        'origin_type' => $answer->type->name,
                        'status' => $answer->chargeLevel,
                    ];
                }

                $effortRecovery['calculated_status'] = $this->translator($effort->latestQuestionnaireHistory->calculatedStatus);

                $effortRecovery['calculated_code'] = $effort->latestQuestionnaireHistory->calculatedStatus;
            }

            $effortRecovery['answers'] = $answerData;
        }

        return $players;
    }

    /**
     * Lists all the players related to a team - version 1
     *
     * @return array
     */
    public function listPlayersV1($teamId, $queryParams)
    {
        $effortPrograms = $this->effortRecoveryRepository->listPlayers($teamId, $queryParams);

        // GET THE LAST PROGRAM RELATED
        foreach ($effortPrograms as $program) {
            if ($program->effort_recovery_id != NULL) {
                // Find the effort program
                $effort = $this->effortRecoveryRepository->findOneBy([
                    'id' => $program->effort_recovery_id
                ]);

                // Initialize an empty array
                $answerData = [];

                // Get the latest questionnaire done to the effort program
                if ($effort->latestQuestionnaireHistory) {
                    // Retrieve the questionnaire history set from the latest related history item
                    foreach ($effort->latestQuestionnaireHistory->answers as $answer) {
                        // Manually parse the needed data to be returned
                        $answerData[] = [
                            'id' => $answer->id,
                            'name' => $answer->name,
                            'origin_type' => $answer->type->name,
                            'status' => $answer->chargeLevel,
                        ];
                    }

                    $program->calculated_status = $this->translator($effort->latestQuestionnaireHistory->calculatedStatus);
                    $program->calculated_code = $effort->latestQuestionnaireHistory->calculatedStatus;
                } else {
                    $program->calculated_status = NULL;
                    $program->calculated_code = NULL;
                }

                // Set it outside the loop in case there's no effort program
                $program->answers = $answerData;
            } else {
                // Or just in case there's not even an effort program related
                $program->answers = [];
                $program->calculated_status = NULL;
                $program->calculated_code = NULL;
            }
        }

        return $effortPrograms;
    }

    /**
     * Lists all effort recovery items depending on the player sent
     *
     * @return array
     */
    public function list($player)
    {
        $recoveries = $this->effortRecoveryRepository->findBy(
            ['player_id' => $player->id],
            ['created_at' => 'DESC'],
            5
        );

        foreach ($recoveries as $recovery) {
            $recovery->strategies;
            $recovery->latestQuestionnaireHistory;
        }

        return $recoveries;
    }

    /**
     * Stores a new effort recovery item depending on the player sent
     *
     * @return object
     */
    public function store($requestData, $player)
    {
        try {
            $effort = $this->effortRecoveryRepository->create([
                'player_id' => $player->id,
                'has_strategy' => $requestData['has_strategy'],
                'user_id' => $requestData['user_id']
            ]);

            if (isset($requestData['effort_recovery_strategy_ids'])) {
                $this->insertStrategyRelations(
                    $requestData['effort_recovery_strategy_ids'],
                    $effort
                );
            }

            return $effort;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Shows an existent effort recovery item
     *
     * @return object
     */
    public function show($effort)
    {
        try {
            $effort->strategies;
            $effort->player;
            $effort->latestQuestionnaireHistory;

            return $effort;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates an existent effort recovery item
     *
     * @return object
     */
    public function update($requestData, $player, $effort)
    {
        try {
            if (isset($requestData['effort_recovery_strategy_ids'])) {
                $this->programStrategyRepository->deleteByCriteria([
                    'effort_recovery_id' => $effort->id,
                ]);

                $this->insertStrategyRelations(
                    $requestData['effort_recovery_strategy_ids'],
                    $effort
                );
            }

            return $this->effortRecoveryRepository->update([
                'has_strategy' => $requestData['has_strategy'] ?? false,
            ], $effort);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes an existent item of effort recovery
     *
     * @return bool
     */
    public function destroy($effortId)
    {
        try {
            $effort = $this->effortRecoveryRepository->findBy([
                'id' => $effortId
            ])->first();

            if (!$effort) {
                throw new Exception('Effort Program Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->effortRecoveryRepository->delete($effortId);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set recovery relations to the items
     *
     * @return void
     */
    private function insertStrategyRelations($strategyIds, $effort)
    {
        foreach ($strategyIds as $strategyId) {
            $this->programStrategyRepository->create([
                'effort_recovery_id' => $effort->id,
                'effort_recovery_strategy_id' => $strategyId
            ]);
        }
    }
}
