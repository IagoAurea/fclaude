<?php

namespace Modules\EffortRecovery\Services;

use Illuminate\Http\Response;
use App\Traits\ResponseTrait;

// Repositories
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireHistoryRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryRepositoryInterface;

// Extra
use Exception;

class WellnessQuestionnaireHistoryService
{
    use ResponseTrait;

    /**
     * @var object $historyRepository
     */
    protected $historyRepository;

    /**
     * @var object $answerRepository
     */
    protected $answerRepository;

    /**
     * @var object $recoveryRepository
     */
    protected $recoveryRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        WellnessQuestionnaireHistoryRepositoryInterface $historyRepository,
        WellnessQuestionnaireAnswerRepositoryInterface $answerRepository,
        EffortRecoveryRepositoryInterface $recoveryRepository
    ) {
        $this->historyRepository = $historyRepository;
        $this->answerRepository = $answerRepository;
        $this->recoveryRepository = $recoveryRepository;
    }

    /**
     * Returns all the historic questionnaire set of items related
     * to the effort recovery program
     * 
     * @return object
     */
    public function index($effortId)
    {
        try {
            $effort = $this->recoveryRepository->findOneBy([
                'id' => $effortId
            ]);

            if (!$effort) {
                throw new Exception('Effort Program Not Found', Response::HTTP_NOT_FOUND);
            }

            $effort->player;
            $effort->questionnaireHistory;

            return $effort;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Stores a questionnaire set of answers into the database
     * 
     * @return array|object
     */
    public function store($requestData, $effortId)
    {
        try {
            $history = $this->historyRepository->create([
                'effort_recovery_id' => $effortId,
            ]);

            foreach ($requestData['answer_items'] as $answer) {
                $this->answerRepository->create([
                    'wellness_questionnaire_history_id'     =>  $history->id,
                    'wellness_questionnaire_answer_item_id' =>  $answer,
                ]);
            }

            return $history;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a questionnaire set of answers into the database
     * 
     * @return array|object
     */
    public function update($requestData, $effortId, $questionnarieId)
    {
        $history = $this->historyRepository->findOneBy([
            'id' => $questionnarieId,
            'effort_recovery_id' => $effortId,
        ]);

        if(!$history) {
            abort(response()->error('History not found', Response::HTTP_NOT_FOUND));
        }

        try {
            $this->answerRepository->deleteByCriteria(['wellness_questionnaire_history_id' => $questionnarieId]);
            
            foreach ($requestData['answer_items'] as $answer) {
                $this->answerRepository->create([
                    'wellness_questionnaire_history_id'     =>  $questionnarieId,
                    'wellness_questionnaire_answer_item_id' =>  $answer,
                ]);
            }

            return $history;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
