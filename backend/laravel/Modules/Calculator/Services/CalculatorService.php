<?php

namespace Modules\Calculator\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Modules\Alumn\Entities\Alumn;
use Modules\Player\Entities\Player;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\Calculator\Repositories\CalculatorItemTypeRepository;
use Modules\Calculator\Repositories\Interfaces\CalculatorItemRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityItemAnswerRepositoryInterface;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityAnswerHistoricalRecordRepositoryInterface;

class CalculatorService
{
    use ResponseTrait;

    /**
     * @var object $calculatorItemRepository
     */
    protected $calculatorItemRepository;

    /**
     * @var object $calculatorItemAnswerRepository
     */
    protected $calculatorItemAnswerRepository;

    /**
     * @var object $calculatorHistoryRepository
     */
    protected $calculatorHistoryRepository;
    
    /**
     * @var object $calculatorItemTypeRepository
     */
    protected $calculatorItemTypeRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        CalculatorItemRepositoryInterface $calculatorItemRepository,
        CalculatorEntityItemAnswerRepositoryInterface $calculatorItemAnswerRepository,
        CalculatorEntityAnswerHistoricalRecordRepositoryInterface $calculatorHistoryRepository,
        CalculatorItemTypeRepository $calculatorItemTypeRepository
    ) {
        $this->calculatorItemRepository = $calculatorItemRepository;
        $this->calculatorItemAnswerRepository = $calculatorItemAnswerRepository;
        $this->calculatorHistoryRepository = $calculatorHistoryRepository;
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
    }

    /**
     * Retrieve last injury risk
     */
    public function lastInjuryRisk($player_id)
    {
        $injuries_risk = $this->getHistory('player', $player_id);

        $risk = (count($injuries_risk) > 0) ? $injuries_risk[0] : null;

        if ($risk) {
            $risk->rank = $this->calculatorItemTypeRepository->getItemType($risk->total_points);
        }
        
        return $risk;
    }

    /**
     * Returns the list of all calculation items depending on the
     * entity key received by parameter
     *
     */
    public function getItems($type)
    {
        try {
            $class = $this->resolveCalculatorClass($type);

            return $this->calculatorItemRepository->findItems($class);
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
    }

    /**
     * Receives a set of answered questions, giving the option ids and
     * creating a new historical record for every entity related.
     *
     * @param Array $requestData
     *
     * @return Void
     */
    public function storeItems($requestData)
    {
        try {
            $class = $this->resolveCalculatorClass($requestData['entity']);

            $historyRecord = $this->calculatorHistoryRepository->create([
                'entity_id' => $requestData['entity_id'],
                'entity_type' => $class
            ]);

            foreach ($requestData['answers'] as $answer) {
                $this->calculatorItemAnswerRepository->create([
                    'calculator_entity_answer_historical_record_id' => $historyRecord->id,
                    'calculator_entity_item_point_value_id' => $answer['option_id']
                ]);
            }

            $totalPoints = $this->calculatorHistoryRepository->calculateTotal(
                $historyRecord->id,
                $this->calculatorItemRepository->findItems($class, false, true)
            );

            $this->calculatorHistoryRepository->update([
                'total_points' => $totalPoints
            ], $historyRecord);

            return $totalPoints;
            
        } catch (Exception $exception) {
            throw $exception;
        }
    }
    
    /**
     * Retrieves the history of all calculation sets donde to a specific
     * entity model
     *
     * @param String $type
     * @param String|Int $entityId
     * @return Array
     */
    public function getHistory($type, $entityId)
    {
        try {
            $class = $this->resolveCalculatorClass($type);

            $historyRecords = $this->calculatorHistoryRepository->findBy([
                'entity_id' => $entityId,
                'entity_type' => $class
            ], [
                'created_at' => 'DESC'
            ], 5);

            foreach ($historyRecords as $record) {
                $record->calculatorEntityItemAnswers;

                foreach ($record->calculatorEntityItemAnswers as $answer) {
                    $answer->calculatorEntityItemPointValue;
                }
            }

            return $historyRecords;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
    }

    /**
     * Return an specific history set of a given entity
     *
     * @return Object
     */
    public function getHistoryItem($type, $entityId, $historyId)
    {
        try {
            $history = $this->calculatorHistoryRepository->findOneBy([
                'id' => $historyId
            ]);

            if (!$history) {
                abort(response()->error('History Item Not Found', Response::HTTP_NOT_FOUND));
            }

            $history->calculatorEntityItemAnswers;

            foreach ($history->calculatorEntityItemAnswers as $answer) {
                $answer->calculatorEntityItemPointValue;
            }

            return $history;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
    }

    /**
     * Returns the classname depending on the key sent via
     * parameter
     *
     * @param string $key
     * @return string
     */
    private function resolveCalculatorClass($key)
    {
        $classes = [
            'injury_prevention' => InjuryPrevention::class,
            'player' => Player::class,
            'alumn' => Alumn::class
        ];

        return $classes[$key];
    }
}
