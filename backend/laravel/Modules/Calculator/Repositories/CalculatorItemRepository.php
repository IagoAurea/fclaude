<?php

namespace Modules\Calculator\Repositories;

use App\Services\ModelRepository;
use Modules\Calculator\Entities\CalculatorItem;
use Modules\Calculator\Repositories\Interfaces\CalculatorItemRepositoryInterface;

// Entities
use Modules\InjuryPrevention\Entities\InjuryPrevention;

class CalculatorItemRepository extends ModelRepository implements CalculatorItemRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'calculator_items';

    /**
     * @var string
     */
    protected $tableTranslations = 'calculator_item_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'calculator_item_id';

    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(CalculatorItem $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return all calculator items with translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Retrieve all calculator items with respective translations
     *
     * @param String $classType
     * @param Bool $visible
     * @param Bool $selectAll
     * @return array
     */
    public function findItems($classType, $visible = true, $selectAll = false)
    {
        $selectionItems = $selectAll ? 'calculator_items.*' : 'calculator_items.id';

        return $this->_model->select($selectionItems)
        ->with([
            'calculatorEntityItemPointValues' => function ($query) use ($selectAll) {

                $selectItems = $selectAll
                    ? 'calculator_entity_item_point_values.*'
                    : [
                        'calculator_entity_item_point_values.id',
                        'calculator_entity_item_point_values.title',
                        'calculator_entity_item_point_values.calculator_item_id'
                    ];

                $query->select($selectItems);
            }
        ])
        ->join('calculator_item_translations', 'calculator_items.id', '=',
            'calculator_item_translations.calculator_item_id')
        ->where('calculator_items.entity_class', $classType)
        ->where('calculator_items.is_visible', $visible)
        ->where('calculator_item_translations.locale', app()->getLocale())
        ->get();
    }
}
