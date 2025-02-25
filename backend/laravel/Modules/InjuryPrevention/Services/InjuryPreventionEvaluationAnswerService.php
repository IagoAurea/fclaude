<?php

namespace Modules\InjuryPrevention\Services;

use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Exception;

// Repositories
use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionRepositoryInterface;
use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionEvaluationAnswerRepositoryInterface;
use Modules\InjuryPrevention\Repositories\Interfaces\EvaluationQuestionRepositoryInterface;

class InjuryPreventionEvaluationAnswerService 
{
    use ResponseTrait;

    /**
     * Needed constants for profile result
     */
    const LOW_PROFILE = 'low';
    const HIGH_PROFILE = 'high';
    const NONE_PROFILE = 'none';

    /**
     * @var object $injuryPreventionRepository
     */
    protected $injuryPreventionRepository;

    /**
     * @var object $injuryEvaluationAnswerRepository
     */
    protected $injuryEvaluationAnswerRepository;

        /**
     * @var object $evaluationQuestionRepository
     */
    protected $evaluationQuestionRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        InjuryPreventionRepositoryInterface $injuryPreventionRepository,
        InjuryPreventionEvaluationAnswerRepositoryInterface $injuryEvaluationAnswerRepository,
        EvaluationQuestionRepositoryInterface $evaluationQuestionRepository
    ) {
        $this->injuryPreventionRepository = $injuryPreventionRepository;
        $this->injuryEvaluationAnswerRepository = $injuryEvaluationAnswerRepository;
        $this->evaluationQuestionRepository = $evaluationQuestionRepository;
    }

    /**
     * Inserts all related answers into the database table
     * 
     * @return void
     */
    public function store($answers, $injuryPrevention)
    {
        try {
            // Check if the injury has no previous answers
            if ($injuryPrevention->is_finished) {
                throw new Exception('Injury prevention has finalized already', Response::HTTP_NOT_ACCEPTABLE);
            }

            // Get all the questions sent 
            $questionIds = array_column($answers, 'evaluation_question_id');

            // Find all the questions not sent in the JSON request
            $excludedAnswers = $this->evaluationQuestionRepository->findNotIn(
                'id', $questionIds
            );

            // Store all the excluded one as false
            foreach($excludedAnswers as $excluded) {
                $this->injuryEvaluationAnswerRepository->create([
                    'evaluation_question_id' => $excluded->id,
                    'injury_prevention_id' => $injuryPrevention->id,
                ]);
            }

            // Set an accumulator
            $totalCount = 0;

            // Now give the respecive values to the ones sent
            foreach($answers as $answer) {
                $this->injuryEvaluationAnswerRepository->create([
                    'evaluation_question_id' => $answer['evaluation_question_id'],
                    'injury_prevention_id' => $injuryPrevention->id,
                    'value' => $answer['value'],
                ]);

                //  Add a point in case the answer is true
                if ($answer['value'] == true) {
                    $totalCount ++;
                }
            }

            // Set the variable is_finished to true
            $this->injuryPreventionRepository->update([
                'is_finished' => true,
                'evaluation_points' => $totalCount,
                'profile_status' => $totalCount < 8 ? self::LOW_PROFILE : self::HIGH_PROFILE,
                'end_date' => Carbon::now()->toDateTimeString(),
            ], $injuryPrevention);

            return $totalCount;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates an existent set of answers
     * 
     * @return void
     */
    public function update($answers, $injuryPrevention)
    {
        try {
            // Now give the respecive values to the ones sent
            foreach($answers as $answer) {
                $this->injuryEvaluationAnswerRepository->update([
                    'value' => $answer['value'],
                ], [
                    'evaluation_question_id' => $answer['evaluation_question_id'],
                    'injury_prevention_id' => $injuryPrevention->id,
                ], true);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
