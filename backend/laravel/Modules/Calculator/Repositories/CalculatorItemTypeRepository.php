<?php

namespace Modules\Calculator\Repositories;

use App\Services\ModelRepository;
use Modules\Calculator\Entities\CalculatorItemType;
use Modules\Calculator\Repositories\Interfaces\CalculatorItemTypeRepositoryInterface;

class CalculatorItemTypeRepository extends ModelRepository implements CalculatorItemTypeRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(CalculatorItemType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Returns rank type according to score with respective translations
     *
     * @param Float $point
     * @return Float
     */
    public function getItemType(Float $point)
    {
        return $this->model
            ->where('range_min', '<', $point)
            ->where('range_max', '>=', $point)
            ->first();
    }
}
