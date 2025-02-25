<?php

namespace Modules\Calculator\Repositories;

use App\Services\ModelRepository;
use Modules\Calculator\Entities\CalculatorEntityAnswerHistoricalRecord;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityAnswerHistoricalRecordRepositoryInterface;

class CalculatorEntityAnswerHistoricalRecordRepository extends ModelRepository
    implements CalculatorEntityAnswerHistoricalRecordRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(CalculatorEntityAnswerHistoricalRecord $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Calculates the total points value depending on the answers saved in storeage
     * and also calculates all the hidden options that must intervenue in case
     * they're not part of the commmon calculation rendering.
     *
     * @return Float
     */
    public function calculateTotal($historyId, $hiddenOptions = [])
    {
        $answerRows = $this->_model->select(
            'calculator_entity_answer_historical_records.id AS history_id',
            'calculator_items.code',
            'calculator_entity_item_point_values.title',
            'calculator_entity_item_point_values.points',
            'calculator_items.percentage',
            'calculator_items.is_visible'
        )->join(
            'calculator_entity_item_answers',
            'calculator_entity_answer_historical_records.id',
            '=',
            'calculator_entity_item_answers.calculator_entity_answer_historical_record_id'
        )->join(
            'calculator_entity_item_point_values',
            'calculator_entity_item_answers.calculator_entity_item_point_value_id',
            '=',
            'calculator_entity_item_point_values.id'
        )->leftjoin(
            'calculator_items',
            'calculator_entity_item_point_values.calculator_item_id',
            '=',
            'calculator_items.id'
        )
        ->where('calculator_entity_answer_historical_records.id', $historyId )
        ->get();

        // Do the common answers sum calculation
        $answerSum = $answerRows->sum(function ($answer) {
            return $answer->points * (float) $answer->percentage;
        });

        // Then search the history item
        $historyItem = $this->_model->find($historyId);

        // Then do the hidden items calculatons
        $hiddenSum = $this->calculateHidden($hiddenOptions, $historyItem->entity);

        return round($answerSum + $hiddenSum, 2);
    }

    /**
     * Receives an array of hidden options and loops thorugh all of them.
     * Once on the loop, it starts calling the calculateByCode function
     * and accumulates it returns values into one var
     *
     * @param Object
     * @return Float
     */
    private function calculateHidden($options, $entity)
    {
        $hiddenAcum = 0;

        foreach ($options as $option) {
            $hiddenAcum += $this->calculateByCode($option, $entity);
        }

        return $hiddenAcum;
    }

    /**
     * This functions makes the point caluclation depending on the option item code
     *
     * Looks inside the option posible responses and checks every evaluation condition
     * by replacing the option $calculation_var into the $optionValue->condition string
     *
     * In case the string evaluation returns a true value, multiply the pointValue points
     * item with the option main percentage and returns it.
     *
     * It also needs an entity object because this will be the referencial object in where
     * the function will search the depending item. for example: if the entity object
     * is an 'InjuryPrevention', it must searchs the related player age value
     *
     * @param Object $option
     * @param Object $entity
     * @return Float
     */
    private function calculateByCode($option, $entity)
    {
        /**
         * String 'calc_age' is related to age evaluation inside InjuryPrevention entity.
         */
        if ($option->code == 'calc_age') {
            // Get the needed age
            $playerAge = $entity->player->age;
            
            foreach ($option->calculatorEntityItemPointValues as $optionValue) {
                // Convert condition string from the option into a valid code string
                $evalString = str_replace(
                    $option->calculation_var,
                    $playerAge,
                    $optionValue->condition
                );

                // Perform the logic evaluation
                $evalResult = eval($evalString);

                // In case the condition applies
                if ($evalResult) {
                    return round($optionValue->points * $option->percentage, 2);
                }
            }
        }

        return 0;
    }
}
